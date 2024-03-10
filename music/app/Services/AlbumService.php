<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\DataAccessExceptions\DataAccessException;
use App\Exceptions\MinioException;
use App\Facades\AuthFacade;
use App\Models\Album;
use App\Repository\Interfaces\IAlbumRepository;
use App\Repository\Interfaces\IArtistRepository;
use App\Repository\Interfaces\IGenreRepository;
use App\Repository\Interfaces\ISongRepository;
use Illuminate\Http\UploadedFile;

class AlbumService
{

    public function __construct(
        private readonly IAlbumRepository    $albumRepository,
        private readonly IArtistRepository   $artistRepository,
        private readonly ISongRepository     $songRepository,
        private readonly IGenreRepository    $genreRepository,
        private readonly PhotoStorageService $photoStorageService,
        private readonly SongService         $songService,
        private readonly CacheStorageService $cacheStorageService
    ) {}

    /**
     * @throws MinioException
     * @throws DataAccessException
     */
    public function saveAlbum(
        string $name,
        UploadedFile $albumPhoto,
        int $genreId
    ): int {
        $this->genreRepository->getById($genreId);

        $photoPath = $this->photoStorageService->saveAlbumPhoto($albumPhoto);

        $authUserId = AuthFacade::getUserId();
        $artist = $this->artistRepository->getByUserId($authUserId);

        return $this->albumRepository->create($name, $photoPath, $artist->id, $genreId);
    }

    /**
     * @throws DataAccessException
     * @throws MinioException
     */
    public function updateAlbum(
        int $albumId,
        ?string $name,
        ?UploadedFile $photoFile,
        ?string $status,
        ?int $genreId
    ): void {

        //$album = $this->getAlbum($albumId);
        $album = $this->albumRepository->getById($albumId);
        $updatedAlbum = $album;

        if ($genreId) {
            $this->genreRepository->getById($genreId);
            $updatedAlbum->genre_id = $genreId;
        }

        if ($name) {
            $updatedAlbum->name = $name;
        }

        if ($photoFile) {
            $this->photoStorageService->updatePhoto($album->photo_path, $photoFile);
        }

        if ($status) {
            $updatedAlbum->status = $status;
        }

        $this->albumRepository->update(
            $albumId,
            $updatedAlbum->name,
            $updatedAlbum->photo_path,
            $updatedAlbum->genre_id
        );

        //$this->deleteAlbumFromCache($albumId);
    }

    /**
     * @throws DataAccessException
     * @throws MinioException
     */
    public function deleteAlbum(int $albumId): void
    {
        //$album = $this->getAlbum($albumId);
        $album = $this->albumRepository->getById($albumId);

        $this->photoStorageService->deletePhoto($album->photo_path);

        $songs = $this->songRepository->getAllByAlbum($albumId);
        foreach ($songs as $song) {
            $this->songService->deleteSong($song->id);
        }

        $this->albumRepository->delete($albumId);
        //$this->deleteAlbumFromCache($albumId);
    }

    // public function getAlbum(int $albumId): Album
    // {
    //     $album = $this->getAlbumFromCache($albumId);

    //     if (!$album) {
    //         $album = $this->albumRepository->getById($albumId);
    //         $this->saveAlbumToCache($album);
    //     }

    //     return $album;
    // }

    // private function saveAlbumToCache(Album $album): void
    // {
    //     $serializedAlbum = serialize($album);
    //     $idInRedis = "album_{$album->id}";

    //     $this->cacheStorageService->saveToCache($idInRedis, $serializedAlbum);
    // }

    // private function getAlbumFromCache(int $albumId): ?Album
    // {
    //     $idInRedis = "album_{$albumId}";

    //     $serializedAlbum = $this->cacheStorageService->getFromCache($idInRedis);
    //     if (!$serializedAlbum) {
    //         return null;
    //     }

    //     $album = unserialize($serializedAlbum);

    //     return $album;
    // }

    // private function deleteAlbumFromCache(int $albumId): void
    // {
    //     $idInRedis = "album_{$albumId}";
    //     $this->cacheStorageService->deleteFromCache($idInRedis);
    // }
}
