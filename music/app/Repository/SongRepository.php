<?php

namespace App\Repository;

use App\Models\Song;
use Illuminate\Support\Facades\DB;

class SongRepository implements SongRepositoryInterface
{
    public function getById($songId): Song|null
    {
        return Song::query()->find($songId);
    }

    public function getAllByAlbum(int $albumId): array
    {
        return Song::query()->where('album_id', $albumId)->get()->all();
        // return DB::table('songs')->where('album_id', $albumId)->get()->all();
    }

    public function create(string $name, string $photoPath, string $musicPath, int $albumId): int
    {
        $song = new Song;
        $song->name = $name;
        $song->likes = 0;
        $song->photo_path = $photoPath;
        $song->music_path = $musicPath;
        $song->album_id = $albumId;

        $song->save();

        return $song->id;

//        return DB::table('songs')->insertGetId([
//            'name' => $name,
//            'likes' => 0,
//            'photo_path' => $photoPath,
//            'music_path' => $musicPath,
//            'album_id' => $albumId,
//        ]);
    }

    public function delete(int $songId): bool
    {
        // TODO: Implement delete() method.
    }

    public function update(string $name, string $photoPath, string $musicPath, int $albumId): bool
    {
        // TODO: Implement update() method.
    }
}
