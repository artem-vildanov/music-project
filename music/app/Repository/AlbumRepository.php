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

    public function getAllByArtist($artistId): array
    {
        $albums = DB::table('albums')->where('artist_id', $artistId)->get()->all();

        $albumsDtoCollection = [];

        foreach ($albums as $album)
        {
            $albumDto = new AlbumDto();
            $albumDto->id = $album->id;
            $albumDto->name = $album->name;
            $albumDto->photoPath = $album->photo_path;
            $albumDto->likes = $album->likes;
            $albumDto->artistId = $album->artist_id;

            $albumsDtoCollection[] = $albumDto;
        }

        return $albumsDtoCollection;
    }

    public function getAllByUser($userId)
    {
        // TODO: Implement getAllByUser() method.
    }

    public function getAllByGenre($genreId)
    {
        // TODO: Implement getAllByGenre() method.
    }

    public function create(AlbumDto $albumDto): false|int
    {
        $albumPhotoPath = $albumDto->photo->store('album_photos', 's3');

        $albumId = DB::table('albums')->insertGetId([
            'name' => $albumDto->name,
            'photo_path' => $albumPhotoPath,
            'likes' => $albumDto->likes,
            'artist_id' =>  $albumDto->artistId,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        foreach ($albumDto->songs as $song)
        {
            $song->musicPath = $song->music->store('music_files', 's3');
            if (!$song->musicPath)
                return false;

            DB::table('songs')->insert([
                'name' => $song->name,
                'likes' => $song->likes,
                'photo_path' => $albumPhotoPath,
                'music_path' => $song->musicPath,
                'album_id' => $albumId,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return $albumId;
    }
}
