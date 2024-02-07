<?php

namespace App\DataTransferObjects;

use Illuminate\Http\UploadedFile;

class SongDto
{
    public int $id;
    public string $name;
    public UploadedFile $photo;
    public string $photoPath;

    public UploadedFile $music;
    public string $musicPath;

    public int $likes;
}
