<?php

namespace App\Providers;

use App\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register() {

    }

    public function boot(Request $request) {
        view()->composer('layouts.shop', function ($view) use ($request) {
            $view->with('_categories', ProductCategory::active()->get());
        });
    }
}