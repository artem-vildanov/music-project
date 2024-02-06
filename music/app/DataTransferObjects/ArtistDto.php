<?php

namespace App\DataTransferObjects;

class ArtistDto
{
    public int $id;
    public string $name;
    public string $photoPath;
    public int $likes;
    public array $albums;
    public GenreDto $genre;

}
