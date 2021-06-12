<?php

//use Illuminate\Support\Facades\Route;

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
/*
Route::get('/', 'MainController@index')->name('main');

Route::get('profile', 'ProfileController@edit')->name('profile.edit');

Route::put('profile', 'ProfileController@update')->name('profile.update');
*/
$router->get('/users', 'UserController@index')->name('user.list');
$router->get('/users/delete/{user}', 'UserController@delete')->name('user.delete');
$router->post('/users/pagination', 'UserController@pagination')->name('user.list.pagination');
$router->get('/users/create', 'UserController@create')->name('user.create');
$router->post('/users/store', 'UserController@store')->name('user.store');
$router->get('/users/{user}', 'UserController@update')->name('user.update');
$router->post('/users/store/update', 'UserController@storeUpdate')->name('user.store.update');
$router->post('/users/store/validation', 'UserController@storeValidation')->name('user.store.validation');
$router->get('/country', 'CountryController@index')->name('country.list');
$router->get('/state/{country}', 'StateController@index')->name('state.country');
$router->get('/city/{state}', 'CityController@index')->name('city.state');

$router->get('/', 'UserController@login')->name('login');
$router->post('/', 'UserController@login')->name('user.login');
$router->get('/profile', 'UserController@profile')->name('user.profile')->middleware('auth');
$router->get('/email', 'EmailController@index')->name('email.list')->middleware('auth');
$router->get('/email/create', 'EmailController@create')->name('email.create')->middleware('auth');
$router->post('/email/store', 'EmailController@store')->name('email.store')->middleware('auth');
$router->get('/logout', 'UserController@logout')->name('user.logout')->middleware('auth');