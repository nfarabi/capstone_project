<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Pagination
    |--------------------------------------------------------------------------
    |
    | Number of items in a page for any paginated Model.
    |
    */

    'pagination' => 25,

    /*
    |--------------------------------------------------------------------------
    | Editable content prefix
    |--------------------------------------------------------------------------
    |
    | Prefix for editable content
    |
    */

    'editable' => [
        'prefix' => \Illuminate\Support\Str::slug(env('DATA_EDITABLE_PREFIX', 'element'))
    ],



];
