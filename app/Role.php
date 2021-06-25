<?php

namespace App;

use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
}
