<?php

namespace App\DataTransferObjects;

use Illuminate\Http\UploadedFile;

class AlbumDto
{
    public int $id;
    public string $name;
    public UploadedFile $photo;
    public string $photoPath;

    public int $likes;
    public int $artistId;
    public array $songs;
}
