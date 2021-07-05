<?php

use App\Http\Controllers\API\BikeController;
use App\Http\Controllers\API\ShopController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'prefix' => '/bike',
    'as' => 'bike.'
], function () {
   Route::get('/', [BikeController::class, 'index'])->name('index'); 
   Route::get('/all', [BikeController::class, 'all'])->name('all'); 
   Route::get('/{bike}', [BikeController::class, 'show'])->name('show'); 
});

Route::group([
    'prefix' => '/shop',
    'as' => 'shop.'
], function () {
   Route::get('/', [ShopController::class, 'index'])->name('index'); 
   Route::get('/all', [ShopController::class, 'all'])->name('all'); 
   Route::get('/{shop}', [ShopController::class, 'show'])->name('show'); 
});