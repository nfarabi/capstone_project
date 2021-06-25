<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
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
        if (auth()->check() === false || auth()->user()->hasAnyRole(['admin', 'super-admin']) === false) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
