<?php

namespace App\DataTransferObjects;

use Illuminate\Http\UploadedFile;

class SongDto
{
    public int $id;
    public string $name;
    public string $photoPath;
    public string $musicPath;
    public int $likes;
    public int $artistId;
    public string $artistName;
}
