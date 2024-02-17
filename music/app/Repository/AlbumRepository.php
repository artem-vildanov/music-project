<?php

namespace App\Repository;

use App\DataTransferObjects\AlbumDto;
use App\Models\Album;
use Illuminate\Support\Facades\DB;
use PhpParser\Builder;


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



    public function create(string $name, string $photoPath, int $artistId): int
    {
        $album = new Album;
        $album->name = $name;
        $album->photo_path = $photoPath;
        $album->artist_id = $artistId;

        $album->likes = 0;
        $album->cdn_folder_id = uniqid(more_entropy: true);
        $album->status = 'private';
        $album->created_at = now();
        $album->updated_at = now();

        $album->save();

        return $album->id;

//        return DB::table('albums')->insertGetId([
//            'name' => $name,
//            'photo_path' => $photoPath,
//            'likes' => 0,
//            'artist_id' =>  $artistId,
//
//            'cdn_folder_id' => uniqid(more_entropy: true),
//            'status' => 'private',
//
//            'created_at' => now(),
//            'updated_at' => now()
//        ]);
    }
}
