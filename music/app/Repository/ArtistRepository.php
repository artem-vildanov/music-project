<?php


namespace App\Repository;

use App\DataTransferObjects\AlbumDto;
use App\DataTransferObjects\ArtistDto;
use Illuminate\Support\Facades\DB;

class ArtistRepository implements ArtistRepositoryInterface
{

    public function getById($id)
    {
        $artist = DB::table('artists')->where('id', $id)->first();

        if (!$artist)
            return null;

        $albums = DB::table('albums')->where('artist_id', $id)->get()->all();

        $artistDto = new ArtistDto();
        $artistDto->id = $artist->id;
        $artistDto->name = $artist->name;
        $artistDto->photoPath = $artist->photo_path;
        $artistDto->likes = $artist->likes;
        $artistDto->albums = $albums;

        return $artistDto;
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


