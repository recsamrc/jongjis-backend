<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'     => config('backpack.base.route_prefix', ''),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('bike', 'BikeCrudController');
    Route::crud('usergroup', 'UserGroupCrudController');
    Route::crud('client', 'ClientCrudController');
    Route::crud('bikecategory', 'BikeCategoryCrudController');
    Route::crud('shop', 'ShopCrudController');
    Route::crud('rental', 'RentalCrudController');
    Route::crud('payment', 'PaymentCrudController');
    Route::crud('penalty', 'PenaltyCrudController');
    Route::crud('advertisement', 'AdvertisementCrudController');
    Route::crud('image', 'ImageCrudController');
}); // this should be the absolute last line of this file