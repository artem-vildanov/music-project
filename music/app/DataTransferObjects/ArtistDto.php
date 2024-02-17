<?php

namespace App\DataTransferObjects;

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

}
