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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/generate/pdf/quote/english', 'PDFController@generateEN')->name('generateQuotePDFen');
Route::post('/generate/pdf/quote/lithuanian', 'PDFController@generateLT')->name('generateQuotePDFlt');


// Route::get('/by', function(){
//     $country1 = 'PL';
// // $country2 = 'PL';
// $vatnum1 = '123456';
// // $vatnum2 = '789012';
//
// //Prepare the URL
// $url = 'http://ec.europa.eu/taxation_customs/vies/viesquer.do?ms='.$country1.'&iso='.$country1.'&vat='.$vatnum1;
//
// $response = file_get_contents($url);
// // Do sth with the response
// echo $response;
// });
