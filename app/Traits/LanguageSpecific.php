<?php

namespace App\Traits;

use App\Language;

trait LanguageSpecific
{
    public function language()
    {
        return $this->belongsTo( Language::class );
    }

    public function scopeFromLanguage( $q, $language )
    {
        if( is_object( $language ) ) {
            return $q->where('language_id', $language->id);
        }

        if( is_integer( $language ) ) {
            return $q->where('language_id', $language);
        }

        return $q->whereHas('language', function( $q ) use( $language ) {
            $q->where('code', $language);
        });
    }
}
