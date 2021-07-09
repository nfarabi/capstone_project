<?php

namespace App\Providers;

use App\Language;
use Cache;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @param Request $request
     *
     * @return void
     */
    public function boot( Request $request )
    {
        Schema::defaultStringLength(191);

        view()->composer('*', function ($view) use( $request )
        {
            $languages = Cache::rememberForever('site::languages', function () {
                return Language::all();
            });

            $view->with('_languages', $languages);
        });

        /**
         * Filter featured items.
         *
         * @param  string|null  $key
         *
         * @return static
         */
        Collection::macro('featured', function ($key = 'is_featured') {
            return $this->filter(function ($item) use ($key) {
                return !empty( $item->$key );
            });
        });

        /**
         * Skip featured items.
         *
         * @param  string|null  $key
         *
         * @return static
         */
        Collection::macro('exceptFeatured', function ($key = 'is_featured') {
            return $this->filter(function ($item) use ($key) {
                return empty( $item->$key );
            });
        });

        // Blade custom directives [BEGIN]
        \Blade::directive('errorClass', function ($field) {
            return '<?php echo $errors->has(' . $field . ') ? "has-error" : ""; ?>';
        });

        \Blade::directive('errorMessage', function ($field) {
            return '<?php echo $errors->has(' . $field . ') ? view("partials.error-message", ["field" => ' . $field . ']) : ""; ?>';
        });
        // Blade custom directives [END]

        // Blade custom if statements [BEGIN]
        \Blade::if('hasMorePages', function ($collection) {
            return $collection->hasPages();
        });
        // Blade custom if statements [END]

        Response::macro('csv', function ($content, $name, $date = true) {
            $name = Str::slug($name);

            if ($date) {
                $name .= ' - ' . Carbon::now();
            }

            $headers = [
                'Content-type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="'.$name.'.csv"',
            ];

            return Response::make($content, 200, $headers);
        });
    }
}
