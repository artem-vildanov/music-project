<?php

namespace App\DataTransferObjects;

use App\Models\Artist;
use Illuminate\Http\UploadedFile;

class ArtistDto
{
    public int $id;
    public string $name;
    public string $photoPath;
    public int $likes;

    /**
     * @var array<AlbumDto>
     */
    public array $albums;
    public int $userId;

    /**
     * @param Artist[] $artists
     * @return ArtistDto[]
     */
    public static function mapArtistsArray(array $artists): array
    {
        $artistDtoCollection = [];
        foreach ($artists as $artist) {
            $artistDtoCollection[] = ArtistDto::mapArtist($artist);
        }

        return $artistDtoCollection;
    }

    public static function mapArtist(Artist $artist): ArtistDto
    {
        $artistDto = new ArtistDto();
        $artistDto->id = $artist->id;
        $artistDto->name = $artist->name;
        $artistDto->likes = $artist->likes;
        $artistDto->photoPath = $artist->photo_path;
        $artistDto->userId = $artist->user_id;

        return $artistDto;
    }
}
