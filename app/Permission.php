<?php

namespace App;

use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission as BasePermission;

class Permission extends BasePermission
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * Set the permission's name.
     *
     * @param  string  $name
     * @return void
     */
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = Str::kebab($name);
    }
}
