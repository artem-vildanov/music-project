<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/greet', \App\Http\Controllers\IndexController::class);

Route::group(['prefix' => 'album', 'middleware' => 'jwt.auth'], function () {
    Route::get('/{id}', [AlbumController::class, 'show']);
});

Route::group(['prefix' => 'artist', 'middleware' => 'jwt.auth'], function () {
    Route::get('/{id}', [ArtistController::class, 'show']);
    Route::post('/create', [ArtistController::class, 'create']);
    Route::group(['middleware' => 'forArtistPermitted'], function () {
        Route::post('/test', [ArtistController::class, 'test']);
        Route::post('/createAlbum', [AlbumController::class, 'create']);
    });
});




Route::group(['prefix' => 'users'], function () {
    Route::post('/signup', [UserController::class, 'signup']);
});

Route::group(['prefix' => 'auth', 'middleware' => 'api'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});
