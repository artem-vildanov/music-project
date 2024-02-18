<?php

namespace App\Services;

use App\Repository\Interfaces\ArtistRepositoryInterface;
use App\Repository\Interfaces\UserRepositoryInterface;
use Illuminate\Http\UploadedFile;

class ArtistService
{
    public function __construct(
        private readonly PhotoStorageService $storageService,
        private readonly ArtistRepositoryInterface $artistRepository,
        private readonly UserRepositoryInterface $userRepository,
    ) {}

    public function saveArtist(string $name, UploadedFile $photoFile): int|null
    {
        $photoPath = $this->storageService->saveArtistPhoto($photoFile);

        if (!$photoPath)
            return null;

        $user = auth()->user();
        $this->userRepository->update($user->id, $user->name, $user->email, 'artist');

        return $this->artistRepository->create($name, $photoPath, $user->id);
    }
}
