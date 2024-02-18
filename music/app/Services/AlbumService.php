<?php

declare(strict_types=1);

namespace App\Services;

use App\Repository\Interfaces\AlbumRepositoryInterface;
use App\Repository\Interfaces\ArtistRepositoryInterface;
use App\Repository\Interfaces\GenreRepositoryInterface;
use App\Repository\Interfaces\SongRepositoryInterface;
use Illuminate\Http\UploadedFile;

class AlbumService
{

    public function __construct(
        private readonly AlbumRepositoryInterface $albumRepository,
        private readonly ArtistRepositoryInterface $artistRepository,
        private readonly SongRepositoryInterface $songRepository,
        private readonly GenreRepositoryInterface $genreRepository,
        private readonly PhotoStorageService $photoStorageService,
        private readonly AudioStorageService $audioStorageService,
    ) {}

    public function saveAlbum(
        string $name,
        UploadedFile $albumPhoto,
        int $genreId
    ): null|int {

        if (!$this->genreRepository->getById($genreId)) {
            return null;
        }

        $artist = $this->artistRepository->getByUserId(auth()->id());

        if (!$artist)
            return null;

        $photoPath = $this->photoStorageService->saveAlbumPhoto($albumPhoto);

        if (!$photoPath)
            return null;

        return $this->albumRepository->create($name, $photoPath, $artist->id, $genreId);
    }

    public function updateAlbum(
        int $albumId,
        ?string $name,
        ?UploadedFile $photoFile,
        ?string $status,
        ?int $genreId
    ): bool {

        $album = $this->albumRepository->getById($albumId);
        $updatedAlbum = $album;

        if ($genreId) {
            if (!$this->genreRepository->getById($genreId)) {
                return false;
            }

            $updatedAlbum->genre_id = $genreId;
        }

        if ($name) {
            $updatedAlbum->name = $name;
        }

        if ($photoFile) {
            if (!$this->photoStorageService->updatePhoto($album->photo_path, $photoFile)) {
                return false;
            }
        }

        if ($status) {
            $updatedAlbum->status = $status;
        }

        return $this->albumRepository->update(
            $albumId,
            $updatedAlbum->name,
            $updatedAlbum->photo_path,
            $updatedAlbum->status,
            $updatedAlbum->genre_id
        );
    }

    public function deleteAlbum(int $albumId): bool
    {
        $album = $this->albumRepository->getById($albumId);
        $songs = $this->songRepository->getAllByAlbum($albumId);

        if (
            $this->photoStorageService->deletePhoto($album->photo_path) and
            $this->albumRepository->delete($albumId)
        ) {
            foreach ($songs as $song) {
                if (!$this->audioStorageService->deleteAudio($song->music_path)) {
                    return false;
                }
            }

            return true;
        } else {
            return false;
        }
    }
}
