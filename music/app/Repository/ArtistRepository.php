<?php


namespace App\Repository;

use App\DataTransferObjects\ArtistDto;
use Illuminate\Support\Facades\DB;

class ArtistRepository implements ArtistRepositoryInterface
{

    public function getById($albumId): ArtistDto|null
    {
        $artist = DB::table('artists')->where('id', $albumId)->first();

        if (!$artist)
            return null;

        $artistDto = new ArtistDto();
        $artistDto->id = $artist->id;
        $artistDto->name = $artist->name;
        $artistDto->photoPath = $artist->photo_path;
        $artistDto->likes = $artist->likes;

        return $artistDto;
    }

    public function getByUserId($userId): ArtistDto|null
    {
        $artist = DB::table('artists')->where('user_id', $userId)->first();

        if (!$artist)
            return null;

        $artistDto = new ArtistDto();
        $artistDto->id = $artist->id;
        $artistDto->name = $artist->name;
        $artistDto->photoPath = $artist->photo_path;
        $artistDto->likes = $artist->likes;

        return $artistDto;
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

    public function create(ArtistDto $artistDto): int|false {

        $artistDto->photoPath = $artistDto->photo->store('artists_photos', 's3');
        if (!$artistDto->photoPath)
            return false;

        return DB::table('artists')->insertGetId([
            'name' => $artistDto->name,
            'photo_path' => $artistDto->photoPath,
            'likes' => $artistDto->likes,
            'user_id' => $artistDto->userId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}


