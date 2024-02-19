<?php

namespace App\DataTransferObjects;

use App\Models\Song;

class SongDto
{
    public int $id;
    public string $name;
    public string $photoPath;
    public string $musicPath;
    public int $likes;
    public int $artistId;
    public string $artistName;

    public static function mapSongsArray(array $songs): array
    {
        $songDtoCollection = [];
        foreach ($songs as $song) {
            $songDtoCollection[] = SongDto::mapSong($song);
        }

        return $songDtoCollection;
    }

    public static function mapSong(Song $song): SongDto
    {
        $songDto = new SongDto();
        $songDto->id = $song->id;
        $songDto->name = $song->name;
        $songDto->likes = $song->likes;
        $songDto->artistId = $song->artist_id;
        $songDto->photoPath = $song->photo_path;
        $songDto->musicPath = $song->music_path;

        return $songDto;
    }
}
