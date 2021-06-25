<?php

namespace App;

use App\Traits\LanguageSpecific;
use Illuminate\Database\Eloquent\Model;

class PageBlock extends Model
{
    use LanguageSpecific;

    public function page()
    {
        return $this->belongsTo( Page::class );
    }
}
