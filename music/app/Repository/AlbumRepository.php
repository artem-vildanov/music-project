<?php

namespace App\Repository;

use App\DataTransferObjects\AlbumDto;
use Illuminate\Support\Facades\DB;

class AlbumRepository implements AlbumRepositoryInterface
{

    public function getById($albumId): AlbumDto|null
    {
        $album = DB::table('albums')->where('id', $albumId)->first();

        if(!$album) {
            return null;
        }

        $songs = DB::table('songs')->where('album_id', $albumId)->get()->all();

        $albumDto = new AlbumDto();
        $albumDto->id = $album->id;
        $albumDto->name = $album->name;
        $albumDto->songs = $songs;
        $albumDto->artistId = $album->artist_id;
        $albumDto->likes = $album->likes;
        $albumDto->photoPath = $album->photo_path;

        return $albumDto;
    }

    public function getAllByArtist($artistId)
    {
        // TODO: Implement getAllByArtist() method.
    }

    public function getAllByUser($userId)
    {
        // TODO: Implement getAllByUser() method.
    }

    public function getAllByGenre($genreId)
    {
        // TODO: Implement getAllByGenre() method.
    }
}
