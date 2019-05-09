<?php

use Illuminate\Routing\Router;
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


Route::get('/', 'LeadsController@new')->name('new-lead');
Route::post('/', 'LeadsController@create')->name('save-lead');
Route::get('/privacy', 'PagesControllers@getPage')->name('privacy-page');



Route::group([
    'prefix'        => 'ajax'
], function (Router $router) {
    $router->post('/zipcode/validate/{zipcode}', 'LeadsController@validateZipcode');
});