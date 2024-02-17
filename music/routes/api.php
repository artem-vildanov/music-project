<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ForArtistPermitted;
use App\Http\Middleware\ForBaseUserPermitted;
use App\Http\Middleware\AlbumOwnershipVerification;
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
    Route::get('/{albumId}', [AlbumController::class, 'show']);
    Route::post('/createAlbum', [AlbumController::class, 'create'])->middleware(ForArtistPermitted::class);;
    Route::group(['prefix' => '{albumId}'], function () {
        Route::group(['prefix' => '{songId}'], function () {
            Route::get('', [SongController::class, 'show']);

            // TODO implement method & create OwnershipMiddleware
            Route::post('/updateSong', [SongController::class, 'update'])->middleware(ForArtistPermitted::class, AlbumOwnershipVerification::class);
            Route::get('/deleteSong', [SongController::class, 'delete'])->middleware(ForArtistPermitted::class, AlbumOwnershipVerification::class);
            // TODO implement method & create OwnershipMiddleware
        });
        Route::post('createSong', [SongController::class, 'create'])->middleware(ForArtistPermitted::class, AlbumOwnershipVerification::class );
        Route::post('deleteAlbum', [AlbumController::class, 'delete'])->middleware(ForArtistPermitted::class, AlbumOwnershipVerification::class );
    });
});

Route::group(['prefix' => 'artist', 'middleware' => 'jwt.auth'], function () {
    Route::get('/{artistId}', [ArtistController::class, 'show']);
    Route::post('/createArtist', [ArtistController::class, 'create'])->middleware(ForBaseUserPermitted::class);
//    Route::group(['middleware' => ForArtistPermitted::class], function () {
//        Route::post('/createAlbum', [AlbumController::class, 'create']);
//    });
});

Route::group(['prefix' => 'user'], function () {
    Route::post('/signup', [UserController::class, 'signup']);
});

Route::group(['prefix' => 'auth', 'middleware' => 'api'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});
