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


Route::get('/', 'LeadsController@newLead')->name('new-lead');
Route::post('/', 'LeadsController@saveLead')->name('save-lead');
Route::get('/privacy', 'PagesControllers@getPage')->name('privacy');
Route::get('/faq', 'PagesControllers@getPage')->name('faq');
Route::get('/about', 'PagesControllers@getPage')->name('about');
Route::get('/contact', 'PagesControllers@getPage')->name('contact');
Route::post('/contact', 'PagesControllers@getPage')->name('contact');



Route::group([
    'prefix'        => 'ajax'
], function (Router $router) {
    $router->post('/zipcode/validate/{zipcode}', 'LeadsController@validateZipcode');
    $router->get('/years','AjaxController@getYears');
    $router->get('/makes/{year}','AjaxController@getMakes');
    $router->get('/models/{year}/{make}','AjaxController@getModels');
    $router->get('/trims/{year}/{make}/{model}','AjaxController@getTrims');
});