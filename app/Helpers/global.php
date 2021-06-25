<?php

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

if (! function_exists('gate_check')) {
    function gate_check($callee_controller, $callee_method, array $permissions = [])
    {
        switch ($callee_method) {
            case 'index':
                $callee_method = 'view';
                break;
            case 'create':
            case 'store':
                $callee_method = 'create';
                break;
            case 'edit':
            case 'update':
                $callee_method = 'edit';
                break;
            case 'destroy':
                $callee_method = 'delete';
                break;
        }

        $model_plural = Str::plural(str_replace('Controller', '', class_basename($callee_controller)));
        $class_gate = Str::kebab($model_plural . '-manage');                // Add <class>-manage as permission to manage all methods of a class
        $method_gate = Str::kebab($model_plural . '-' . $callee_method);    // Add <class>-<method> as permission to manage specific method of a class

        array_push($permissions, $class_gate, $method_gate);
        $permissions = array_unique($permissions);

        if (! Gate::any($permissions)) {
            abort(401);
        }
    }
}

/*
 * Generate storage link public url
 */
if (! function_exists('storage')) {
    function storage ($path) {
        return asset( "storage/{$path}" );
    }
}
