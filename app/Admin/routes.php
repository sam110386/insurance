<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->post("/leads/{id}/notes/","AdminLeadsController@addNotes")->name('lead.notes.add');
    $router->resource('leads', 'AdminLeadsController');
    $router->post("/leads/update/status/{id}","AdminLeadsController@updateStatus")->name('lead.status.update');
    $router->resource('vehicles', 'VehiclesController');
});
