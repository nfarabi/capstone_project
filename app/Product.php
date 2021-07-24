<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;

class Product extends Model
{
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
        'short_description',
        'long_description',
        'sku',
        'price',
        'inventory',
        'discount',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'display_price',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            // Set UUID while creating a product
            $product->uuid = (string) Str::orderedUuid();
        });
    }

    public function category()
    {
        return $this->belongsTo( ProductCategory::class );
    }

    public function merchant()
    {
        return $this->belongsTo( User::class );
    }

    /**
     * Get the product's display price.
     *
     * @return string
     */
    public function getDisplayPriceAttribute()
    {
        $moneyFormatter = new IntlMoneyFormatter(
            new \NumberFormatter('en_US', \NumberFormatter::CURRENCY),
            new ISOCurrencies()
        );

        return $this->attributes['display_price'] = $moneyFormatter->format(Money::USD($this->price));
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
