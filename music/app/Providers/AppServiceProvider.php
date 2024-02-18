<?php

namespace App\Providers;

use App\Repository\AlbumRepository;
use App\Repository\ArtistRepository;
use App\Repository\GenreRepository;
use App\Repository\Interfaces\AlbumRepositoryInterface;
use App\Repository\Interfaces\ArtistRepositoryInterface;
use App\Repository\Interfaces\GenreRepositoryInterface;
use App\Repository\Interfaces\SongRepositoryInterface;
use App\Repository\Interfaces\UserRepositoryInterface;
use App\Repository\SongRepository;
use App\Repository\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        $this->app->bind(AlbumRepositoryInterface::class, AlbumRepository::class);
        $this->app->bind(ArtistRepositoryInterface::class, ArtistRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(SongRepositoryInterface::class, SongRepository::class);
        $this->app->bind(GenreRepositoryInterface::class, GenreRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
