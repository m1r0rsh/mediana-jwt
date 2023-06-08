<?php

use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register', [AuthController::class, 'register']);

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

    Route::group(['prefix' => 'main'], function (){
        Route::get('list', [\App\Http\Controllers\ApiResource\NewsController::class, 'listNews']);
        Route::get('show/{id}', [\App\Http\Controllers\ApiResource\NewsController::class, 'showNews']);
        Route::get('myprofile', [\App\Http\Controllers\ApiResource\NewsController::class, 'myprofile']);
        Route::get('privateList', [\App\Http\Controllers\ApiResource\NewsController::class, 'privateList']);
    });

    Route::get('check', function (Request $request){
        return auth()->user();
    });

    Route::group(['prefix' => 'admin'], function (){
        Route::group(['prefix' => 'news'], function (){
            Route::get('list', [NewsController::class, 'listNews']);
            Route::get('list/{id}', [NewsController::class, 'newsId']);
            Route::post('create', [NewsController::class, 'createNews']);
            Route::put('update/{id}', [NewsController::class, 'updateNews']);
            Route::delete('delete/{id}', [NewsController::class, 'deleteNews']);
        });

        Route::group(['prefix' => 'user'], function (){
            Route::get('list', [UserController::class, 'listUser']);
            Route::get('list/{id}', [UserController::class, 'userId']);
            Route::patch('update/{id}', [UserController::class, 'updateNews']);
            Route::delete('delete/{id}', [UserController::class, 'deleteUser']);
        });

    });


});

