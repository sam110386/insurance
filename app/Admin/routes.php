<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

// you should put this after `Admin::registerAuthRoutes();`
Route::resource('admin/auth/users', \App\Admin\Controllers\CustomUserController::class)->middleware(config('admin.route.middleware'));

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->post("/leads/{id}/notes/","AdminLeadsController@addNotes")->name('lead.notes.add');
    $router->post("/leads/update/status/{id}","AdminLeadsController@updateStatus")->name('lead.status.update');
    $router->post("/leads/bulk/email/","AdminLeadsController@sendBulkEmail")->name('lead.bulk.email');
    $router->resource('leads', 'AdminLeadsController');

    $router->resource('vehicles', 'VehiclesController');
});
