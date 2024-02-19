<?php

namespace App\Repository;

use App\Models\Album;
use App\Repository\Interfaces\AlbumRepositoryInterface;


class AlbumRepository implements AlbumRepositoryInterface
{

    public function getById(int $albumId): Album|null
    {
        return Album::query()->find($albumId);

        // return DB::table('albums')->where('id', $albumId)->first();
    }

    public function getAllByArtist(int $artistId): array
    {
        return Album::query()->where('artist_id', $artistId)->get()->all();
        //return DB::table('albums')->where('artist_id', $artistId)->get()->all();
    }

    public function getAllByUser(int $userId)
    {
        // TODO: Implement getAllByUser() method.
    }

    public function getAllByGenre(int $genreId)
    {
        // TODO: Implement getAllByGenre() method.
    }

    public function create(
        string $name,
        string $photoPath,
        int $artistId,
        int $genreId
    ): int {
        $album = new Album;
        $album->name = $name;
        $album->photo_path = $photoPath;
        $album->artist_id = $artistId;
        $album->genre_id = $genreId;

        $album->likes = 0;
        $album->cdn_folder_id = uniqid(more_entropy: true);
        $album->status = 'private';
        $album->created_at = now();
        $album->updated_at = now();

        $album->save();

        return $album->id;
    }

    /**
     * @param int $albumId
     * @param string $name
     * @param string $status
     * @return bool
     */
    public function update(
        int $albumId,
        string $name,
        string $status,
        int $genreId
    ): bool {
        $album = Album::query()->find($albumId);
        $album->name = $name;
        $album->status = $status;
        $album->genre_id = $genreId;
        return $album->save();
    }

    /**
     * @param int $albumId
     * @return bool
     */
    public function delete(int $albumId): bool
    {
        $album = Album::query()->find($albumId);
        return $album->delete();
    }
}
