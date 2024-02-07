<?php

namespace App\DataTransferObjects;

use Illuminate\Http\UploadedFile;

class ArtistDto
{
    public int $id;
    public string $name;

    public UploadedFile $photo;
    public string $photoPath;
    public int $likes;
    public array $albums;
    public GenreDto $genre;

    public int $userId;

}
