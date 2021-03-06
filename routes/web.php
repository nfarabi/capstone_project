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

        // Product routes [BEGIN]
        Route::prefix('products')->as('products.')->group(function () {
            Route::get('/copy', 'ProductController@copy')->name('copy');
            Route::post('/copy', 'ProductController@copyProcess')->name('copy-process');
            Route::get('/import', 'ProductController@import')->name('import');
            Route::post('/import', 'ProductController@importProcess')->name('import-process');
            Route::put('/{product}/activate', 'ProductController@activate')->name('activate');
        });
        Route::resource('/products', 'ProductController');
        // Product routes [END]

        // ProductCategory routes [BEGIN]
        Route::prefix('product-categories')->as('product-categories.')->group(function () {
            Route::put('/{productCategory}/activate', 'ProductCategoryController@activate')->name('activate');
        });
        Route::resource('/product-categories', 'ProductCategoryController')->except(['show']);
        // ProductCategory routes [END]

        Route::resource('/product-discounts', 'ProductDiscountController');
        Route::resource('/product-inventories', 'ProductInventoryController');

        // Misc routes [BEGIN]
        Route::get('/misc/clear-cache', 'MiscController@clearCache')->name('misc.clear-cache');
        // Misc routes [END]

        Route::resource('/permissions', 'PermissionController');
        Route::resource('/roles', 'RoleController');
        Route::resource('/users', 'UserController');
    });

    Auth::routes(['verify' => true]);

    Route::namespace('Shop')->group(function (){
        // Product routes [BEGIN]
        Route::get('/', 'ProductController@index')->name('home');
        Route::get('/product/{product}', 'ProductController@show')->name('product.show');
        // Product routes [END]

        // Cart routes [BEGIN]
        Route::prefix('cart')->as('cart.')->group(function () {
            Route::get('/', 'CartController@index')->name('index');
            Route::post('/{product}', 'CartController@store')->name('store');
            Route::delete('/{id}', 'CartController@destroy')->name('destroy');
        });
    });

    Route::namespace('Api')->prefix('api/v1')->group(function (){
        // Product routes [BEGIN]
        Route::prefix('products')->as('api.products.')->group(function (){
            Route::get('/', 'ProductController@index')->name('index');
            Route::get('/{product}', 'ProductController@show')->name('show');
        });
        // Product routes [END]

        // Cart routes [BEGIN]
        Route::prefix('cart')->as('api.cart.')->group(function () {
            Route::get('/', 'CartController@index')->name('index');
            Route::post('/{product}', 'CartController@store')->name('store');
            Route::delete('/{product}', 'CartController@destroy')->name('destroy');
        });
        // Cart routes [END]
    });

    Route::get('/{pageSlug}', 'PageController@show')->name('pages.show');
});
