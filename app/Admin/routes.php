<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

// you should put this after `Admin::registerAuthRoutes();`
Route::resource('admin/auth/users', \App\Admin\Controllers\CustomUserController::class)->middleware(config('admin.route.middleware'));

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => ['guest','web'],
], function (Router $router) {
    $router->get('/password/forgot','AuthController@forgotPassword')->name('forgot-password');
    $router->post('/password/forgot','AuthController@sendPasswordResetToken')->name('forgot-password-post');
    $router->get('/password/reset/{token}','AuthController@passwordResetView')->name('password-reset');
    $router->post('/password/reset/{token}','AuthController@passwordReset')->name('password-reset-post');

});
Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->get('/mail/test', 'HomeController@testMail')->name('test.mail');
    $router->get('/move/leads', 'LeadAssignmentController@moveAssignments');
    $router->get('/leads/recent/updates', 'NotesController@recent')->name('admin.updates');
    $router->get('/leads/recent/updates/{id}/edit', 'NotesController@edit')->name('admin.update_note');
    $router->match(['put','patch'],'/leads/recent/updates/{id}', 'NotesController@updateNote')->name('admin.update_note_post');

    $router->post("/leads/{id}/notes/","AdminLeadsController@addNotes")->name('lead.notes.add');
    $router->post("/leads/update/status/{id}","AdminLeadsController@updateStatus")->name('lead.status.update');
    $router->post("/leads/update/bulk/current/status/","AdminLeadsController@updateBulkCurrentStatus")->name('lead.bulk_status_update');
    $router->post("/leads/update/current/status/{id}","AdminLeadsController@updateCurrentStatus")->name('lead.currentstatus.update.post');
    $router->get("/leads/update/current/status/{id}/{status}","AdminLeadsController@updateCurrentStatus")->name('lead.currentstatus.update');
    $router->post("/leads/bulk/email/","AdminLeadsController@sendBulkEmail")->name('lead.bulk.email');
    $router->resource('leads', 'AdminLeadsController');
    $router->resource('security', 'PermissionController');

    $router->get("/leads/advance/search",'AdminLeadsController@advanceSearch')->name('lead-advance-search');
    $router->get("/leads/advance/search/result",'AdminLeadsController@advanceSearchResult')->name('lead-advance-search-post');

    $router->get("/leads/{from}/{to}",'AdminLeadsController@index')->name('lead.list');

    $router->resource('vehicles', 'VehiclesController');
    $router->resource('groups', 'GroupsController');
    $router->get('/api/assignment/list','LeadAssignmentController@getAssignmentList')->name('api.assignment.list');
    $router->post('/assign/lead','LeadAssignmentController@assignLead')->name('lead.assignment');

    $router->resource('affiliates', 'AffiliateController');

    $router->match(['put','patch','post'],'auth/setting', 'AuthController@saveProfile')->name('user.profile.update');
});
