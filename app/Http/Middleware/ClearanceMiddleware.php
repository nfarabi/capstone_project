<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class ClearanceMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->hasRole('super-admin')) {
            return $next($request);
        }

        $admin_route_name_parts = explode('.', $request->route()->getName());   // Split route name as array
        array_shift($admin_route_name_parts);                                   // Stripping 'admin' from array
        $model_plural = $admin_route_name_parts[0];

        if (! empty ($admin_route_name_parts[1])) {
            switch ($admin_route_name_parts[1]) {
                case 'index':
                    $admin_route_name_parts[1] = 'view';
                    break;
                case 'create':
                case 'store':
                    $admin_route_name_parts[1] = 'create';
                    break;
                case 'edit':
                case 'update':
                    $admin_route_name_parts[1] = 'edit';
                    break;
                case 'destroy':
                    $admin_route_name_parts[1] = 'delete';
                    break;
            }
        }

        $class_gate = Str::kebab($model_plural . '-manage');                    // Add <model_plural>-manage as gate to manage all methods of a class
        $method_gate = Str::kebab(implode('-', $admin_route_name_parts));       // Add <model_plural>-<rest_of_the_parts_separated_by_hyphen> as gate to manage specific method of a class

        if (! Gate::any([$class_gate, $method_gate])) {
            abort(401);
        }

        return $next($request);
    }
}
