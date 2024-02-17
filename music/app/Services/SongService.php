<?php

namespace App\Services;

use App\DataTransferObjects\SongDto;
use App\Repository\AlbumRepositoryInterface;
use App\Repository\SongRepositoryInterface;
use Illuminate\Http\UploadedFile;

class SongService
{
    public function __construct(
        private readonly StorageService $storageService,
        private readonly SongRepositoryInterface $songRepository,
        private readonly AlbumRepositoryInterface $albumRepository,
    ) {
    }

    public function saveSong(string $name, UploadedFile $musicFile, int $albumId): int|false
    {
        $album = $this->albumRepository->getById($albumId);

        $musicPath = $this->storageService->storeAudio($album->cdn_folder_id, $musicFile);

        return $this->songRepository->create($name, $album->photo_path, $musicPath, $albumId);
    }
}
