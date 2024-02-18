<?php

namespace App\DataTransferObjects;

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
}
