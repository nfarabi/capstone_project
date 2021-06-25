<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['language'])->group(function () {
    Route::namespace('Admin')->prefix('admin')->middleware(['verified', 'admin', 'clearance'])->as('admin.')->group(function (){
        Route::get('/', 'DashboardController@index')->name('dashboard.index');

        // Language routes [BEGIN]
        Route::prefix('languages')->as('languages.')->group(function () {
            Route::get('/copy', 'LanguageController@copy')->name('copy');
            Route::post('/copy', 'LanguageController@copyProcess')->name('copy-process');
            Route::put('/{language}/activate', 'LanguageController@activate')->name('activate');
            Route::get('/switch', 'LanguageController@switchLanguage')->name('switch-language');
        });
        Route::resource('/languages', 'LanguageController');
        // Language routes [END]

        // Page routes [BEGIN]
        Route::prefix('pages')->as('pages.')->group(function () {
            Route::get('/copy', 'PageController@copy')->name('copy');
            Route::post('/copy', 'PageController@copyProcess')->name('copy-process');
            Route::put('/{page}/publish', 'PageController@publish')->name('publish');
            Route::get('/{page}/blocks', 'PageBlockController@edit')->name('blocks.edit');
            Route::put('/{page}/blocks', 'PageBlockController@update')->name('blocks.update');
            Route::get('/{page}/translations', 'PageTranslationController@edit')->name('translations.edit');
            Route::put('/{page}/translations', 'PageTranslationController@update')->name('translations.update');
        });
        Route::resource('/pages', 'PageController')->except(['show']);
        // Page routes [END]

        // Misc routes [BEGIN]
        Route::get('/misc/clear-cache', 'MiscController@clearCache')->name('misc.clear-cache');
        // Misc routes [END]

        Route::resource('/permissions', 'PermissionController');
        Route::resource('/roles', 'RoleController');
        Route::resource('/users', 'UserController');
    });

    Auth::routes(['verify' => true]);
    Route::get('/{pageSlug}', 'PageController@show')->name('pages.show');
    Route::get('/', 'PageController@show')->name('home');
});
