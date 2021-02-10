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

Route::prefix('v1')->group(function () {
    Route::group([
    
            'middleware' => 'api',
            'prefix' => 'auth'

        ], function ($router) {

            Route::post('login', 'Api\v1\AuthController@login');
            Route::post('logout', 'Api\v1\AuthController@logout');
            Route::post('refresh', 'Api\v1\AuthController@refresh');
            Route::post('me', 'Api\v1\AuthController@me');

        });
    });
