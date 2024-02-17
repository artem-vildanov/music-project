<?php

namespace App\Mappers;

use App\DataTransferObjects\AlbumDto;
use App\Models\Album;


class AlbumMapper
{
    /**
     * @param Album $album map from
     * @return AlbumDto
     */
    public function map(Album $album): AlbumDto
    {
        $albumDto = new AlbumDto();
        $albumDto->id = $album->id;
        $albumDto->name = $album->name;
        $albumDto->likes = $album->likes;
        $albumDto->photoPath = $album->photo_path;
        $albumDto->artistId = $album->artist_id;

        return $albumDto;
    }

    /**
     * @param array<Album> $albums
     * @return array<AlbumDto>
     */
    public function mapMultiple(array $albums): array
    {
        /** @var array<AlbumDto> $albumDtoCollection */
        $albumDtoCollection = [];

        foreach ($albums as $album)
        {
            $albumDto = new AlbumDto();
            $albumDto->id = $album->id;
            $albumDto->name = $album->name;
            $albumDto->likes = $album->likes;
            $albumDto->photoPath = $album->photo_path;
            $albumDto->artistId = $album->artist_id;

            $albumDtoCollection[] = $albumDto;
        }

        return $albumDtoCollection;
    }
}
