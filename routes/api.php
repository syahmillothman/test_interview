<?php

use App\Http\Controllers\Api\v1\Admin\UsersController;
use App\Http\Controllers\Api\v1\Admin\TodoAdminController;
use App\Http\Controllers\Api\v1\User\TodoController;
use App\Http\Controllers\Api\v1\ChangePasswordController;
use App\Http\Controllers\Api\v1\LoginController;
use App\Http\Controllers\Api\v1\LogoutController;
use App\Http\Controllers\Api\v1\ProfileController;
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

Route::group(['prefix' => 'v1'], function () {
    Route::post('login', LoginController::class);
    Route::post('logout', LogoutController::class);
    Route::resource('me', ProfileController::class)->middleware('auth:api');
    Route::post('changepassword', ChangePasswordController::class);

    Route::group(['prefix' => 'admin', 'middleware' => ['roles.admin', 'auth:api']], function () {
        Route::resource('users', UsersController::class);
        Route::resource('todos', TodoAdminController::class);
    });


    Route::group(['prefix' => 'user', 'middleware' => ['roles.user', 'auth:api']], function () {
        Route::resource('todos', TodoController::class);
    });
});
