<?php

namespace App\Traits;

use App\Language;

trait Publishable
{
    public function scopePublished( $q )
    {
        return $q->whereNotNull('published_at');
    }

    public function scopeUnpublished( $q )
    {
        return $q->whereNull('published_at');
    }
}
