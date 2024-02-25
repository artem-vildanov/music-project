<?php


namespace App\Repository;

use App\Exceptions\DataAccessExceptions\ArtistException;
use App\Exceptions\DataAccessExceptions\DataAccessException;
use App\Models\Artist;
use App\Repository\Interfaces\IArtistRepository;

class ArtistRepository implements IArtistRepository
{
    public function getById(int $artistId): Artist
    {
        $artist = Artist::query()->find($artistId);
        if (!$artist) {
            throw ArtistException::notFound($artistId);
        }

        return $artist;
    }


    public function getMultipleByIds(array $artistIds): array
    {
        return Artist::query()->whereIn('id', $artistIds)->get()->all();
    }

    public function getByUserId(int $userId): Artist
    {
        $artist = Artist::query()->where('user_id', $userId)->first();
        if (!$artist) {
            throw ArtistException::notFoundByUserId($userId);
        }

        return $artist;
    }

    public function getUserFavourites($userId): array
    {
        // TODO: Implement getAllByUser() method.
        return [];
    }

    public function getAllByGenre($genreId): array
    {
        // TODO: Implement getAllByGenre() method.
        return [];
    }

    public function create(string $name, string $photoPath, int $userId): int
    {
        $artist = new Artist;

        $artist->name = $name;
        $artist->photo_path = $photoPath;
        $artist->user_id = $userId;
        $artist->likes = 0;
        $artist->created_at = now();
        $artist->updated_at = now();

        if (!$artist->save()) {
            throw ArtistException::failedToCreate();
        }

        return $artist->id;
    }

    public function update(int $artistId, string $name): void
    {
        $artist = new Artist();

        try {
            $artist = $this->getById($artistId);
        } catch (DataAccessException $e) {
            throw ArtistException::failedToUpdate($artistId);
        }

        $artist->name = $name;
        if (!$artist->save()) {
            throw ArtistException::failedToUpdate($artistId);
        }
    }

    public function delete(int $artistId): void
    {
        $artist = new Artist();

        try {
            $artist = $this->getById($artistId);
        } catch (DataAccessException $e) {
            throw ArtistException::failedToDelete($artistId);
        }

        if (!$artist->delete()) {
            throw ArtistException::failedToDelete($artistId);
        }
    }
}


