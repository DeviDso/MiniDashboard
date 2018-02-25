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
    Route::resource('requestType', 'RequestTypeController', ['except' => ['create', 'edit']]);
    Route::resource('requestStatus', 'RequestStatusController', ['except' => ['create', 'edit']]);
    Route::resource('categories', 'CategoriesController', ['except' => ['create', 'edit']]);
    Route::resource('products', 'ProductsController', ['except' => ['create', 'edit']]);
    Route::resource('orderStatus', 'OrderStatusController', ['except' => ['create', 'edit']]);
    Route::resource('orders', 'OrderController', ['except' => ['create', 'edit']]);
    Route::resource('orderData', 'OrderDataController', ['except' => ['create', 'edit']]);
    Route::resource('users', 'UserController', ['except' => ['create', 'edit']]);
    Route::resource('quotes', 'QuotesController', ['except' => ['create', 'edit']]);
    Route::resource('pdf', 'PDFController', ['except' => ['create', 'edit']]);
    Route::resource('warehouses', 'WarehousesController', ['except' => ['create', 'edit']]);
});
