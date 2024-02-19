<?php


namespace App\Repository;

use App\Models\Artist;
use App\Repository\Interfaces\ArtistRepositoryInterface;

class ArtistRepository implements ArtistRepositoryInterface
{

    public function getById(int $artistId): Artist|null
    {
        return Artist::query()->find($artistId);
        //return DB::table('artists')->where('id', $artistId)->first();
    }

    public function getByUserId(int $userId): Artist|null
    {
        return Artist::query()->where('user_id', $userId)->first();
        //return DB::table('artists')->where('user_id', $userId)->first();
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

        $artist->save();

        return $artist->id;

//        return DB::table('artists')->insertGetId([
//            'name' => $name,
//            'photo_path' => $photoPath,
//            'likes' => 0,
//            'user_id' => $userId,
//            'created_at' => now(),
//            'updated_at' => now(),
//        ]);
    }

    /**
     * @param int $artistId
     * @param string $name
     * @param string $photoPath
     * @return bool
     */
    public function update(int $artistId, string $name): bool
    {
        $artist = Artist::query()->find($artistId);
        $artist->name = $name;
        return $artist->save();
    }

    /**
     * @param int $artistId
     * @return bool
     */
    public function delete(int $artistId): bool
    {
        $artist = Artist::query()->find($artistId);
        return $artist->delete();
    }
}


