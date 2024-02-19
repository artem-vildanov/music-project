<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckAlbumExists;
use App\Http\Middleware\CheckAlbumStatus;
use App\Http\Middleware\CheckArtistExists;
use App\Http\Middleware\CheckEmailExists;
use App\Http\Middleware\CheckSongExists;
use App\Http\Middleware\ForArtistPermitted;
use App\Http\Middleware\ForBaseUserPermitted;
use App\Http\Middleware\AlbumOwnershipVerification;
use App\Http\Middleware\OwnershipVerification;
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

Route::get('/greet', \App\Http\Controllers\IndexController::class);

Route::group(['prefix' => 'artist', 'middleware' => 'jwt.auth'], function () {
    Route::post('/createArtist', [ArtistController::class, 'create'])->middleware(ForBaseUserPermitted::class);

    Route::group(['prefix' => '{artistId}', 'middleware' => [CheckArtistExists::class]], function() {
        Route::get('', [ArtistController::class, 'show']);

        Route::group(['middleware' => OwnershipVerification::class], function() {
            Route::post('updateArtist', [ArtistController::class, 'update']);
            Route::delete('deleteArtist', [ArtistController::class, 'delete']);
        });

        Route::group(['prefix' => 'album'], function () {
            Route::post('/createAlbum', [AlbumController::class, 'create'])->middleware(ForArtistPermitted::class);

            Route::group(['prefix' => '{albumId}', 'middleware' => [CheckAlbumExists::class, CheckAlbumStatus::class]], function () {
                Route::get('', [AlbumController::class, 'show']);

                Route::group(['middleware' => [ForArtistPermitted::class, AlbumOwnershipVerification::class]], function() {
                    Route::post('createSong', [SongController::class, 'create']);
                    Route::delete('deleteAlbum', [AlbumController::class, 'delete']);
                    Route::post('updateAlbum', [AlbumController::class, 'update']);
                });

                Route::group(['prefix' => '{songId}', 'middleware' => CheckSongExists::class], function () {
                    Route::get('', [SongController::class, 'show']);

                    Route::group(['middleware' => [ForArtistPermitted::class, AlbumOwnershipVerification::class]], function() {
                        Route::post('/updateSong', [SongController::class, 'update']);
                        Route::delete('/deleteSong', [SongController::class, 'delete']);
                    });
                });
            });
        });
    });
});

Route::group(['prefix' => 'user'], function () {
    Route::post('/signup', [UserController::class, 'signup'])->middleware(CheckEmailExists::class);
});

Route::group(['prefix' => 'auth', 'middleware' => 'api'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});
