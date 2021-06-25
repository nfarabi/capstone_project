<?php

namespace App;

use Cache;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
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
        'label',
        'code',
        'locale',
        'address',
        'copyright',
        'facebook_url',
        'instagram_url',
        'linkedin_url'
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::saved(function () {
            Cache::forget('site::languages');
        });

        static::deleted(function () {
            Cache::forget('site::languages');
        });
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class);
    }

    public function activate($activate)
    {
        if (! $this->activated_at && $activate) {
            $this->activated_at = Carbon::now();
        } elseif ($this->activated_at && ! $activate) {
            $this->activated_at = null;
        }
    }
}
