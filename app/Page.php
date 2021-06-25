<?php

namespace App;

use App\Traits\Slugify;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;
use simplehtmldom\HtmlDocument;

class Page extends Model
{
    use Slugify;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'meta' => 'array',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'published_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'image',
        'code_html',
        'code_css',
        'code_js',
    ];

    public static function boot()
    {
        parent::boot();

        static::saved(function ($post) {
            // When a page is marked as homepage, reset any existing homepage
            if ($post->is_homepage) {
                Page::isHomepage()->where('id', '!=', $post->id)->update(['is_homepage' => null]);
            }
        });
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function blocks()
    {
        return $this->hasMany( PageBlock::class );
    }

    public function feature($feature)
    {
        if (! $this->is_featured && $feature) {
            $this->is_featured = Carbon::now();
        } elseif ($this->is_featured && ! $feature) {
            $this->is_featured = null;
        }
    }

    public function homepage($homepage)
    {
        if (! $this->is_homepage && $homepage) {
            $this->is_homepage = Carbon::now();
        } elseif ($this->is_homepage && ! $homepage) {
            $this->is_homepage = null;
        }
    }

    public function setPrivate($is_private)
    {
        if (! $this->is_private && $is_private) {
            $this->is_private = Carbon::now();
        } elseif ($this->is_private && ! $is_private) {
            $this->is_private = null;
        }
    }

    public function publish($publish)
    {
        if (! $this->published_at && $publish) {
            $this->published_at = Carbon::now();
        } elseif ($this->published_at && ! $publish) {
            $this->published_at = null;
        }
    }

    public function getFeaturedImage()
    {
        return asset( $this->image );
    }

    public function getPermalink()
    {
        return url( '/' . $this->slug );
    }

    public function getMeta()
    {
        $array = [];

        $array['description'] = $this->excerpt;

        $array['og:title'] = $this->title;
        $array['og:description'] = $this->excerpt;
        $array['og:type'] = 'website';
        $array['og:image'] = $this->getFeaturedImage();
        $array['og:url'] = $this->getPermalink();

        foreach( collect( $this->meta ) as $key => $content )
        {
            $array[ $key ] = $content;
        }

        return $array;
    }

    public function scopeIsHomepage( $q )
    {
        return $q->whereNotNull('is_homepage');
    }

    public function getTemplate()
    {
        $view = 'pages.show.' . $this->slug;

        if ( View::exists( $view ) ) {
            return $view;
        }

        return 'pages.show';
    }

    public function getBlockArray( $language )
    {
        $data = [];
        $blocks = $this->blocks()->fromLanguage( $language )->get();

        // Get the blocks from the html
        preg_match_all('/data-' . config('cms.editable.prefix') . '-edit="([A-Za-z-_0-9]+)"/', $this->code_html, $matches);
        $keys = $matches[1];

        // $html = HtmlWeb::str_get_html( $this->code_html );
        $html = (new HtmlDocument())->load( $this->code_html );

        foreach( $keys as $key ) {
            // Find the element for each block
            $element = $html->find('*[data-' . config('cms.editable.prefix') . '-edit="' . $key . '"]', 0);

            // Get the element label (display name) and original html to use if there is no translation set
            $label = $element->{'data-' . config('cms.editable.prefix') . '-label'};
            $original = $element->innertext;
            $block = $blocks->where('key', $key)->first();

            // Use src for img tag instead of innertext
            if ( $element->tag == 'img' ) {
                $original = $element->src;
            }

            // Add href along with innertext for a tag
            if ( $element->tag == 'a' ) {
                $href_key = $key . 'Link';
                $href_label = $label . 'Link';
                $original_href = $element->href;

                $href_block = $blocks->where('key', $href_key)->first();

                $data[ $href_key ] = (object) [
                    'tag' => $element->tag,
                    'key' => $href_key,
                    'label' => $href_label,
                    'original' => $original_href,
                    'language' => $href_block ? $href_block->content : null
                ];
            }

            // Add the key, label, content and translated content to an array
            $data[ $key ] = (object) [
                'tag' => $element->tag,
                'key' => $key,
                'label' => $label,
                'original' => $original,
                'language' => $block ? $block->content : null
            ];
        }

        return $data;
    }

    public function saveBlocks( Language $language, array $data )
    {
        $blocks = $this->blocks()->fromLanguage( $language )->get();

        foreach( $data as $key => $content )
        {
            // Loop through submitted blocks and check if block exists by key
            // If no block exists create a new block object with key, language id and page id
            if( ! $block = $blocks->firstWhere('key', $key) ) {
                $block = new PageBlock();
                $block->key = $key;
                $block->language()->associate( $language );
                $block->Page()->associate( $this );
            }

            // Save the block content
            $block->content = $content;
            $block->save();
        }
    }

    public function render( Language $language )
    {
        $blocks = $this->blocks()->fromLanguage( $language )->get();

        $html = (new HtmlDocument())->load( $this->code_html );

        foreach( $html->find('*[data-' . config('cms.editable.prefix') . '-edit]') as $element ) {
            $key = $element->{'data-' . config('cms.editable.prefix') . '-edit'};

            if( $blocks->where('key', $key)->count() ) {
                if ( $element->tag == 'img' ) { // Render image
                    $element->src = $blocks->firstWhere('key', $key)->content;
                } else { // Render everything else
                    $element->innertext = $blocks->firstWhere('key', $key)->content;
                }
            }

            // Render href for a tag
            if ( $element->tag == 'a' && $blocks->where('key', $key . 'Link')->count() ) {
                $element->href = $blocks->firstWhere('key', $key . 'Link')->content;
            }
        }

        // TODO: Manage shortcode
        // return Editor::shortcode($html);
        return $html;
    }
}
