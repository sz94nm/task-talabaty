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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::group(["prefix" => "/users"] ,function () {
    Route::get('/', 'UserController@index');
    Route::get('/all', 'UserController@getUsers');
    Route::get('/{id}/edit', 'UserController@edit');
    Route::delete('/{id}', 'UserController@destroy');
    Route::patch('/{id}', 'UserController@update');
    Route::get('/create', 'UserController@create');
    Route::post('/', 'UserController@store');

});


Route::group(["prefix" => "/tickets"] ,function () {
    Route::get('/', 'TicketController@index');
    Route::get('/done', 'TicketController@getDoneTickets');
    Route::get('/live', 'TicketController@getLiveTickets');
    Route::post('/', 'TicketController@store');
    Route::patch('/{id}/', 'TicketController@updateTicket');

});



Route::group(["prefix" => "/dashboard"] ,function () {
//

    Route::get('/', 'DashboardController@Index');
    Route::get('/operation', 'DashboardController@operationAccess');

});

Auth::routes(['register' => false,'reset'=>false]);

