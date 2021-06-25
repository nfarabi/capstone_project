<?php

namespace App\Http\Middleware;

use App;
use App\Language;
use Closure;
use Cookie;
use URL;

class SetDefaultLocaleForUrls
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
        if ( Cookie::has('languageCode') ) {
            $language = Language::whereCode( Cookie::get('languageCode') )->firstOrfail();
        } else {
            $language = Language::firstOrfail();
        }

        $request->attributes->add([
            '_language' => $language
        ]);

//        URL::defaults([ 'countryCode' => $country->code ]);
        // Set Application Locale
        App::setLocale( $language->locale );

        $response = $next($request);

        if( get_class( $response ) == 'Symfony\Component\HttpFoundation\BinaryFileResponse' ) {
            return $response;
        }

        return $response->withCookie( Cookie::forever( 'languageCode', $language->code ) );
    }
}
