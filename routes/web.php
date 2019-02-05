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
Route::post('/register', 'AuthController@registerPost')->name('register');

Route::get('/logout', 'AuthController@logout')->name('logout');

Route::get('/project/create', 'ProjectController@create')->name('project.create');
Route::post('/project/create', 'ProjectController@createPost')->name('project.create.post');
Route::get('/project/{id}', 'ProjectController@show')->name('project');

// Rotas para o JS
Route::post('/api/client/create', 'ClientController@create')->name('api.client.create');

Route::get('/api/user/search', 'UserController@search')->name('api.user.search');