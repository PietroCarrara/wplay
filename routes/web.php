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

Route::get('/', 'HomeController@index')->name('home');

Route::get('/login', 'AuthController@login')->name('login');
Route::post('/login', 'AuthController@loginPost')->name('login.post');

Route::get('/register', 'AuthController@register')->name('register');
Route::post('/register', 'AuthController@registerPost')->name('register.post');

Route::get('/logout', 'AuthController@logout')->name('logout');

Route::get('/client/create', 'ClientController@create')->name('client.create.post');
Route::post('/client/create', 'ClientController@createPost')->name('client.create');
Route::get('/client/search', 'ClientController@search')->name('client.search');
Route::get('/client/{id}', 'ClientController@show')->name('client.show');
Route::post('/client/{id}', 'ClientController@edit')->name('client.edit');

Route::get('/user/search', 'UserController@search')->name('user.search');
Route::get('/user/{id}/makeadmin', 'UserController@makeAdmin')->name('user.makeadmin');
Route::get('/user/{id}/removeadmin', 'UserController@removeAdmin')->name('user.removeadmin');
Route::get('/user/{id}/report', 'UserController@report')->name('user.report');

Route::get('/project/all', 'ProjectController@showAll')->name('project.all');
Route::post('/project/{id}/tasks', 'TaskController@createPost')->name('project.tasks.create.post');
Route::get('/project/{projId}/task/{taskId}', 'TaskController@show')->name('project.task');
Route::get('/project/{projId}/task/{taskId}/join', 'TaskController@joinTask')->name('project.task.join');
Route::get('/project/{projId}/task/{taskId}/quit', 'TaskController@quitTask')->name('project.task.quit');
Route::get('/project/{projId}/task/{taskId}/togglevote', 'TaskController@toggleVoteTask')->name('project.task.vote');
Route::post('/project/{projId}/task/{taskId}/comment', 'TaskController@commentPost')->name('project.task.comment.create.post');

Route::get('/project/create', 'ProjectController@create')->name('project.create');
Route::post('/project/create', 'ProjectController@createPost')->name('project.create.post');
Route::get('/project/{id}', 'ProjectController@show')->name('project');
Route::post('/project/{id}', 'ProjectController@editPost')->name('project.edit.post');
Route::get('/project/{id}/report', 'ProjectController@report')->name('project.report');
Route::get('/project/{id}/terminate', 'ProjectController@terminate')->name('project.terminate');

// Rotas para o JS
Route::post('/api/client/create', 'ClientController@createPost')->name('api.client.create');

Route::get('/api/user/search', 'UserController@search')->name('api.user.search');