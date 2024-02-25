<?php

namespace App\Services;

use App\Exceptions\DataAccessExceptions\DataAccessException;
use App\Exceptions\MinioException;
use App\Models\Playlist;
use App\Repository\Interfaces\IAlbumRepository;
use App\Repository\Interfaces\IArtistRepository;
use App\Repository\Interfaces\IGenreRepository;
use App\Repository\Interfaces\IPlaylistRepository;
use App\Repository\Interfaces\ISongRepository;
use Illuminate\Http\UploadedFile;

class PlaylistService
{
    public function __construct(
        private readonly IPlaylistRepository $playlistRepository,
        private readonly PhotoStorageService $photoStorageService,
    ) {}

    /**
     * @throws DataAccessException
     * @throws MinioException
     */
    public function savePlaylist(
        string $name,
        ?UploadedFile $playlistPhoto,
    ): int {
        $photoPath = $this->photoStorageService->savePlaylistPhoto($playlistPhoto);
        return $this->playlistRepository->create($name, $photoPath, auth()->id());
    }

    /**
     * @throws MinioException
     * @throws DataAccessException
     */
    public function updatePlaylist(
        int $playlistId,
        ?string $name,
        ?UploadedFile $playlistPhoto
    ): void
    {
        $playlist = $this->playlistRepository->getById($playlistId);
        $updatedPlaylist = $playlist;

        if ($name) {
            $updatedPlaylist->name = $name;
        }

        if ($playlistPhoto) {
            $this->photoStorageService->updatePhoto($playlist->photo_path, $playlistPhoto);
        }

        $this->playlistRepository->update(
            $playlistId,
            $updatedPlaylist->name,
        );
    }

    /**
     * @throws DataAccessException
     * @throws MinioException
     */
    public function deletePlaylist(int $playlistId): void
    {
        $playlist = $this->playlistRepository->getById($playlistId);

        if ($playlist->photo_path) {
            $this->photoStorageService->deletePhoto($playlist->photo_path);
        }

        $this->playlistRepository->delete($playlistId);
    }

}
