<?php

declare(strict_types=1);

namespace App\Services;

use App\DataTransferObjects\AlbumDto;
use App\DataTransferObjects\SongDto;
use App\Repository\AlbumRepositoryInterface;
use App\Repository\ArtistRepositoryInterface;
use App\Repository\SongRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;

class AlbumService
{

    public function __construct(
        private readonly AlbumRepositoryInterface $albumRepository,
        private readonly ArtistRepositoryInterface $artistRepository,
        private readonly StorageService $storageService)
    {

    }

    public function saveAlbum(string $name, UploadedFile $albumPhoto): false|int
    {
        $artist = $this->artistRepository->getByUserId(auth()->id());

        if (!$artist)
            return false;

        $photoPath = $this->storageService->storeAlbumPhoto($albumPhoto);

        if (!$photoPath)
            return false;

        return $this->albumRepository->create($name, $photoPath, $artist->id);
    }
}
