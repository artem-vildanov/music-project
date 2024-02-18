<?php

namespace App\Services;

use App\Repository\Interfaces\AlbumRepositoryInterface;
use App\Repository\Interfaces\SongRepositoryInterface;
use Illuminate\Http\UploadedFile;

class SongService
{
    public function __construct(
        private readonly AudioStorageService $storageService,
        private readonly SongRepositoryInterface $songRepository,
        private readonly AlbumRepositoryInterface $albumRepository,
    ) {
    }

    public function saveSong(string $name, UploadedFile $musicFile, int $albumId): int|false
    {
        $album = $this->albumRepository->getById($albumId);

        $musicPath = $this->storageService->saveAudio($album->cdn_folder_id, $musicFile);

        return $this->songRepository->create($name, $album->photo_path, $musicPath, $albumId);
    }

    public function updateSong(int $songId, ?string $name, ?UploadedFile $musicFile): bool
    {
        $song = $this->songRepository->getById($songId);
        $updatedSong = $song;

        if ($name) {
            $updatedSong->name = $name;
        }

        if ($musicFile) {
            if (!$this->storageService->updateAudio($song->music_path, $musicFile)) {
                return false;
            }
        }

        return $this->songRepository->update(
            $updatedSong->id,
            $updatedSong->name,
            $updatedSong->music_path,
            $updatedSong->photo_path
        );
    }

    public function deleteSong(int $songId): bool
    {
        $song = $this->songRepository->getById($songId);

        if (
            $this->storageService->deleteAudio($song->music_path) and
            $this->songRepository->delete($songId)
        ) {
            return true;
        } else {
            return false;
        }
    }
}
