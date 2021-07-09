<?php

namespace App;

use App\Traits\Slugify;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use Slugify;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'activated_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function parent()
    {
        return $this->belongsTo( ProductCategory::class );
    }

    public function activate($activate)
    {
        if (! $this->activated_at && $activate) {
            $this->activated_at = Carbon::now();
        } elseif ($this->activated_at && ! $activate) {
            $this->activated_at = null;
        }
    }

    /**
     * Scope a query to only include active categories.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->whereNotNull('activated_at');
    }
}
