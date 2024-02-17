<?php

namespace App\Services;

use App\DataTransferObjects\AlbumDto;
use App\DataTransferObjects\ArtistDto;
use App\Repository\AlbumRepositoryInterface;
use App\Repository\ArtistRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Illuminate\Http\UploadedFile;

class ArtistService
{
    public function __construct(
        private readonly StorageService $storageService,
        private readonly ArtistRepositoryInterface $artistRepository,
        private readonly UserRepositoryInterface $userRepository,
    ) {}

    public function saveArtist(string $name, UploadedFile $photoFile): int|null
    {
        $photoPath = $this->storageService->storeArtistPhoto($photoFile);

        if (!$photoPath)
            return null;

        $user = auth()->user();
        $this->userRepository->update($user->id, $user->name, $user->email, 'artist');

        return $this->artistRepository->create($name, $photoPath, $user->id);
    }
}
