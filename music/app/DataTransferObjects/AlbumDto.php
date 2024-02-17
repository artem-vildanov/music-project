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

    /**
     * @var array<SongDto>
     */
    public array $songs;
}
