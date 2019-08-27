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
    $router->get('/mail/test', 'HomeController@testMail')->name('test.mail');
    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->get('/leads/recent/updates', 'NotesController@recent')->name('admin.home');


    $router->post("/leads/{id}/notes/","AdminLeadsController@addNotes")->name('lead.notes.add');
    $router->post("/leads/update/status/{id}","AdminLeadsController@updateStatus")->name('lead.status.update');
    $router->post("/leads/update/current/status/{id}","AdminLeadsController@updateCurrentStatus")->name('lead.currentstatus.update.post');
    $router->get("/leads/update/current/status/{id}/{status}","AdminLeadsController@updateCurrentStatus")->name('lead.currentstatus.update');
    $router->post("/leads/bulk/email/","AdminLeadsController@sendBulkEmail")->name('lead.bulk.email');
    $router->resource('leads', 'AdminLeadsController');
    $router->get("/leads/{from}/{to}",'AdminLeadsController@index')->name('lead.list');

    $router->resource('vehicles', 'VehiclesController');
    $router->resource('groups', 'GroupsController');
    $router->get('/api/assignment/list','LeadAssignmentController@getAssignmentList')->name('api.assignment.list');

    $router->post('/assign/lead','LeadAssignmentController@assignLead')->name('lead.assignment');

});
