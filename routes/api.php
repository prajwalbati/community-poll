<?php

use Illuminate\Http\Request;

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

Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('polls', 'PollsController@index');
Route::get('polls/{id}', 'PollsController@show');
Route::post('polls', 'PollsController@store');
Route::put('polls/{poll}', 'PollsController@update');
Route::delete('polls/{poll}', 'PollsController@delete');

Route::any('errors', 'PollsController@errors');

Route::apiResource('questions', 'QuestionsController');

Route::get('polls/{poll}/questions', 'PollsController@questions');

Route::get('files/get', 'FilesController@show');
Route::post('files/create', 'FilesController@create');

/*Route::group(['middleware' => 'auth:api'], function() {
    Route::get('articles', 'ArticleController@index');
    Route::get('articles/{article}', 'ArticleController@show');
    Route::post('articles', 'ArticleController@store');
    Route::put('articles/{article}', 'ArticleController@update');
    Route::delete('articles/{article}', 'ArticleController@delete');
});*/
