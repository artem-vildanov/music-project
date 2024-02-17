<?php

namespace App\Mappers;

use App\DataTransferObjects\ArtistDto;
use App\Models\Artist;

class ArtistMapper
{
    /**
     * @param Artist $artist
     * @return ArtistDto
     */
    public function map(Artist $artist): ArtistDto
    {
        $artistDto = new ArtistDto();
        $artistDto->id = $artist->id;
        $artistDto->name = $artist->name;
        $artistDto->likes = $artist->likes;
        $artistDto->photoPath = $artist->photo_path;
        $artistDto->userId = $artist->user_id;

        return $artistDto;
    }


    /**
     * @param array<Artist> $artists
     * @return array<ArtistDto>
     */
    public function mapMultiple(array $artists): array
    {

    }
}
