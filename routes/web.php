<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('home');
});
Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::name('google.index')->get('login/google', 'Auth\LoginController@redirectToProvider');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');
Route::name('google.webhook')->post('google/webhook', 'GoogleWebhookController');

Route::middleware(['auth'])->group(function () {
    Route::name('hue.index')->get('/hue', 'HueController@index');
    Route::name('events.index')->get('/events', 'EventsController@index');

    Route::name('boards.index')->get('/boards', 'BoardsController@index');
    Route::name('boards.show')->get("/boards/{id}", 'BoardsController@show');

    Route::get('api/events', 'EventsController@index');

    Route::get('api/calendars/{calendar}/events', 'Api\CalendarEventsController@index');
});
