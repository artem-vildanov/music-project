<?php

namespace App\Services;

use App\Repository\Interfaces\AlbumRepositoryInterface;
use App\Repository\Interfaces\ArtistRepositoryInterface;
use App\Repository\Interfaces\UserRepositoryInterface;
use Illuminate\Http\UploadedFile;

class ArtistService
{
    public function __construct(
        private readonly PhotoStorageService $photoStorageService,
        private readonly ArtistRepositoryInterface $artistRepository,
        private readonly AlbumRepositoryInterface $albumRepository,
        private readonly UserRepositoryInterface $userRepository,
        private readonly AlbumService $albumService
    ) {}

    public function saveArtist(string $name, UploadedFile $photoFile): int|null
    {
        $photoPath = $this->photoStorageService->saveArtistPhoto($photoFile);

        if (!$photoPath)
            return null;

        $user = auth()->user();
        $this->userRepository->update($user->id, $user->name, $user->email, 'artist');

        return $this->artistRepository->create($name, $photoPath, $user->id);
    }

    public function updateArtist(int $artistId, ?string $name, ?UploadedFile $photoFile): bool
    {
        $artist = $this->artistRepository->getById($artistId);
        $updatedArtist = $artist;

        if ($name) {
            $updatedArtist->name = $name;
        }

        if ($photoFile) {
            if (!$this->photoStorageService->updatePhoto($artist->photo_path, $photoFile)) {
                return false;
            }
        }

        return $this->artistRepository->update(
            $artistId,
            $updatedArtist->name
        );
    }

    public function deleteArtist(int $artistId): bool
    {
        $artist = $this->artistRepository->getById($artistId);

        if ($this->photoStorageService->deletePhoto($artist->photo_path)) {

            $albums = $this->albumRepository->getAllByArtist($artist->id);
            foreach ($albums as $album) {
                if (!$this->albumService->deleteAlbum($album->id)) {
                    return false;
                }
            }

            $this->artistRepository->delete($artistId);

            $user = auth()->user();
            $this->userRepository->update(
                $user->id,
                $user->name,
                $user->email,
                'base_user'
            );

            return true;
        } else {
            return false;
        }
    }
}
