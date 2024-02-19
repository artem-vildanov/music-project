<?php

namespace App\DataTransferObjects;

use App\Models\Album;
use Illuminate\Http\UploadedFile;

class AlbumDto
{
    public int $id;
    public string $name;
    public string $photoPath;
    public int $likes;
    public int $artistId;
    public string $artistName;
    public int $genreId;
    public string $genreName;

    /**
     * @var array<SongDto>
     */
    public array $songs;

    /**
     * @param Album[] $albums
     * @return AlbumDto[]
     */
    public static function mapAlbumsArray(array $albums): array {

        $albumDtoCollection = [];

        foreach ($albums as $album) {
            $albumDtoCollection[] = AlbumDto::mapAlbum($album);
        }

        return $albumDtoCollection;
    }

    public static function mapAlbum(Album $album): AlbumDto {
        $albumDto = new AlbumDto();
        $albumDto->id = $album->id;
        $albumDto->name = $album->name;
        $albumDto->photoPath = $album->photo_path;
        $albumDto->likes = $album->likes;
        $albumDto->artistId = $album->artist_id;
        $albumDto->genreId = $album->genre_id;

        return $albumDto;
    }
}
