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

Route::group(['prefix' => 'topics'], function()
{
	// topics
	Route::post('/list', 'Api\TopicsController@list');
	Route::post('/create', 'Api\TopicsController@create');
});


Route::group(['prefix' => 'comments'], function()
{
	// topics
	Route::post('/list', 'Api\CommentsController@list');
	Route::post('/create', 'Api\CommentsController@create');
});
