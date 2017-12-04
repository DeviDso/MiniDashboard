<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => '/V1', 'namespace' => 'Api\V1', 'as' => 'api.'], function(){
    Route::resource('clients', 'ClientsController', ['except' => ['create', 'edit']]);
    Route::resource('requests', 'RequestsController', ['except' => ['create', 'edit']]);
    Route::resource('requestType', 'requestTypeController', ['except' => ['create', 'edit']]);
    Route::resource('requestStatus', 'requestStatusController', ['except' => ['create', 'edit']]);
    Route::resource('categories', 'categoriesController', ['except' => ['create', 'edit']]);
    Route::resource('products', 'productsController', ['except' => ['create', 'edit']]);
    Route::resource('orderStatus', 'orderStatusController', ['except' => ['create', 'edit']]);
    Route::resource('orders', 'orderController', ['except' => ['create', 'edit']]);
    Route::resource('orderData', 'orderDataController', ['except' => ['create', 'edit']]);
    Route::resource('user', 'UserController', ['except' => ['create', 'edit']]);
});
