<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavouriteAlbumsController;
use App\Http\Controllers\FavouriteArtistsController;
use App\Http\Controllers\FavouriteGenresController;
use App\Http\Controllers\FavouriteSongsController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckAlbumExists;
use App\Http\Middleware\CheckAlbumIsFavourite;
use App\Http\Middleware\CheckAlbumStatus;
use App\Http\Middleware\CheckArtistExists;
use App\Http\Middleware\CheckArtistIsFavourite;
use App\Http\Middleware\CheckEmailExists;
use App\Http\Middleware\CheckGenreExists;
use App\Http\Middleware\CheckGenreIsFavourite;
use App\Http\Middleware\CheckSongExists;
use App\Http\Middleware\CheckSongInPlaylist;
use App\Http\Middleware\CheckSongIsFavourite;
use App\Http\Middleware\ForArtistPermitted;
use App\Http\Middleware\ForBaseUserPermitted;
use App\Http\Middleware\AlbumOwnershipVerification;
use App\Http\Middleware\OwnershipVerification;
use App\Http\Middleware\PlaylistOwnershipVerification;
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

Route::group(['prefix' => 'artist', 'middleware' => 'jwt.auth'], function () {
    Route::post('/createArtist', [ArtistController::class, 'create'])->middleware(ForBaseUserPermitted::class);

    Route::group(['prefix' => '{artistId}', 'middleware' => [CheckArtistExists::class]], function() {
        Route::get('', [ArtistController::class, 'show']);
        Route::get('albumsMadeByArtist', [ArtistController::class, 'showAlbumsMadeByArtist']);
        Route::put('addToFavourites', [FavouriteArtistsController::class, 'addToFavouriteArtists'])->middleware(CheckArtistIsFavourite::class);
        Route::put('deleteFromFavourites', [FavouriteArtistsController::class, 'deleteFromFavouriteArtists']);

        Route::group(['middleware' => OwnershipVerification::class], function() {
            Route::post('updateArtist', [ArtistController::class, 'update']);
            Route::delete('deleteArtist', [ArtistController::class, 'delete']);
        });

        Route::group(['prefix' => 'album'], function () {
            Route::post('/createAlbum', [AlbumController::class, 'create'])->middleware(ForArtistPermitted::class);

            Route::group(['prefix' => '{albumId}', 'middleware' => [CheckAlbumExists::class, CheckAlbumStatus::class]], function () {
                Route::get('', [AlbumController::class, 'show']);
                Route::get('albumSongs', [AlbumController::class, 'showSongsInAlbum']);
                Route::put('addToFavourites', [FavouriteAlbumsController::class, 'addToFavouriteAlbums'])->middleware(CheckAlbumIsFavourite::class);
                Route::put('deleteFromFavourites', [FavouriteAlbumsController::class, 'deleteFromFavouriteAlbums']);

                Route::group(['middleware' => [ForArtistPermitted::class, OwnershipVerification::class]], function() {
                    Route::delete('deleteAlbum', [AlbumController::class, 'delete']);
                    Route::post('updateAlbum', [AlbumController::class, 'update']);
                });

                Route::group(['prefix' => 'song'], function () {
                    Route::post('createSong', [SongController::class, 'create'])->middleware([ForArtistPermitted::class, OwnershipVerification::class]);

                    Route::group(['prefix' => '{songId}', 'middleware' => CheckSongExists::class], function () {
                        Route::get('', [SongController::class, 'show']);
                        Route::put('addToFavourites', [FavouriteSongsController::class, 'addToFavouriteSongs'])->middleware(CheckSongIsFavourite::class);
                        Route::put('deleteFromFavourites', [FavouriteSongsController::class, 'deleteFromFavouriteSongs']);

                        Route::group(['middleware' => PlaylistOwnershipVerification::class], function () {
                            Route::put('addToPlaylist/{playlistId}', [PlaylistController::class, 'addSongToPlaylist'])->middleware(CheckSongInPlaylist::class);
                            Route::put('deleteFromPlaylist/{playlistId}', [PlaylistController::class, 'deleteSongsFromPlaylist']);
                        });

                        Route::group(['middleware' => [ForArtistPermitted::class, OwnershipVerification::class]], function() {
                            Route::post('/updateSong', [SongController::class, 'update']);
                            Route::delete('/deleteSong', [SongController::class, 'delete']);
                        });
                    });
                });


            });
        });
    });
});

Route::group(['prefix' => 'genre', 'middleware' => 'jwt.auth'], function() {
    Route::get('/all', [GenreController::class, 'showAll']);

    Route::group(['prefix' => '{genreId}', 'middleware' => CheckGenreExists::class], function() {
        Route::get('', [GenreController::class, 'show']);
        Route::put('addToFavourites', [FavouriteGenresController::class, 'addToFavouriteGenres'])->middleware(CheckGenreIsFavourite::class);
        Route::put('deleteFromFavourites', [FavouriteGenresController::class, 'deleteFromFavouriteGenres']);
        Route::get('albumsByGenre', [GenreController::class, 'albumsWithGenre']);
    });
});

Route::group(['prefix' => 'user'], function () {
    Route::post('/signup', [UserController::class, 'signup'])->middleware(CheckEmailExists::class);
    Route::group(['middleware' => 'jwt.auth'], function() {
        Route::get('/favouriteAlbums', [FavouriteAlbumsController::class, 'showFavouriteAlbums']);
        Route::get('/favouriteSongs', [FavouriteSongsController::class, 'showFavouriteSongs']);
        Route::get('/favouriteArtists', [FavouriteArtistsController::class, 'showFavouriteArtists']);
        Route::get('/favouriteGenres', [FavouriteGenresController::class, 'showFavouriteGenres']);
        Route::group(['prefix' => 'playlist'], function () {
            Route::get('userPlaylists', [PlaylistController::class, 'showUserPlaylists']);
            Route::post('createPlaylist', [PlaylistController::class, 'create']);
            Route::group(['prefix' => '{playlistId}', 'middleware' => PlaylistOwnershipVerification::class], function () {
                Route::get('', [PlaylistController::class, 'show']);
                Route::get('playlistSongs', [PlaylistController::class, 'showSongsInPlaylist']);
                Route::post('updatePlaylist', [PlaylistController::class, 'update']);
                Route::delete('deletePlaylist', [PlaylistController::class, 'delete']);
            });
        });
    });
});

Route::group(['prefix' => 'auth', 'middleware' => 'api'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});
