<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. 
|
*/

// Default view - Home page
Route::get('/', function () {
    return view('welcome');
});

// Home page
Route::get('welcome', function () {
    return view('welcome');
});

// Redirect to the Group page
Route::get('groups', function () {
    return view('groups');
});

// route to show the login form
Route::get('login', array('uses' => 'LoginController@showLogin'));

// route to process the form
Route::post('login', array('uses' => 'LoginController@doLogin'));

// Delete user
Route::delete('/user/delete/{id}', 'UserController@destroy');

// Add user
Route::post('/user/add', 'UserController@add');

// Add group
Route::post('/group/add', 'UserController@addGroup');

// Delete group
Route::delete('/group/delete/{id}', 'UserController@destroyGroup');

// Gest list of user with group information
Route::get('/group/users/', 'UserController@listUsers');

// Modify group
Route::put('/group/{id}', 'UserController@modifyGroup');