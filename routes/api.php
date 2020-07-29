<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('boards',  ['uses' => 'BoardsController@index']);
Route::post('boards',  ['uses' => 'BoardsController@store']);
Route::get('boards/{id}',  ['uses' => 'BoardsController@show']);
Route::patch('boards/{id}',  ['uses' => 'BoardsController@update']);
Route::delete('boards/{id}',  ['uses' => 'BoardsController@destroy']);

Route::post('boards/{id}/invite',  ['uses' => 'BoardsInvitationsController@store']);
Route::delete('boards/{id}/invite',  ['uses' => 'BoardsInvitationsController@destroy']);

Route::get('boards/{board}/statuses',  ['uses' => 'StatusesController@index']);
Route::post('boards/{board}/statuses',  ['uses' => 'StatusesController@store']);
Route::patch('boards/{board}/statuses',  ['uses' => 'StatusesController@updateOrderAll']);
Route::patch('boards/{board}/statuses/{id}',  ['uses' => 'StatusesController@update']);
Route::delete('boards/{board}/statuses/{id}',  ['uses' => 'StatusesController@destroy']);

Route::get('statuses/favorites',  ['uses' => 'FavoriteStatusesController@index']);
Route::post('statuses/{status}/favorite',  ['uses' => 'FavoriteStatusesController@store']);
Route::delete('statuses/{status}/favorite',  ['uses' => 'FavoriteStatusesController@destroy']);

Route::get('statuses/{status}/tasks',  ['uses' => 'TasksController@index']);
Route::post('statuses/{status}/tasks',  ['uses' => 'TasksController@store']);
Route::patch('statuses/{status}/tasks',  ['uses' => 'TasksController@updateOrderAll']);
Route::patch('statuses/{status}/tasks/{id}',  ['uses' => 'TasksController@update']);
Route::delete('statuses/{status}/tasks/{id}',  ['uses' => 'TasksController@destroy']);

Route::get('tasks/{task}/objectives',  ['uses' => 'TaskObjectivesController@index']);
Route::post('tasks/{task}/objectives',  ['uses' => 'TaskObjectivesController@store']);
Route::patch('tasks/{task}/objectives/{id}',  ['uses' => 'TaskObjectivesController@update']);
Route::delete('tasks/{task}/objectives/{id}',  ['uses' => 'TaskObjectivesController@destroy']);
