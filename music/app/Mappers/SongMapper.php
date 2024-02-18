<?php

namespace App\Mappers;

use App\DataTransferObjects\SongDto;
use App\Models\Song;

class SongMapper
{
    /**
     * @param Song $song
     * @return SongDto
     */
    public function map(Song $song): SongDto
    {
        $songDto = new SongDto();
        $songDto->id = $song->id;
        $songDto->name = $song->name;
        $songDto->likes = $song->likes;
        $songDto->photoPath = $song->photo_path;
        $songDto->musicPath = $song->music_path;
        $songDto->artistId = $song->artist_id;

        return $songDto;
    }

    /**
     * @param array<Song> $songs
     * @return array<SongDto>
     */
    public function mapMultiple(array $songs): array
    {
        /** @var array<SongDto> $songDtoCollection */
        $songDtoCollection = [];

        foreach($songs as $song)
        {
            $songDto = $this->map($song);
            $songDtoCollection[] = $songDto;
        }

        return $songDtoCollection;
    }
}
