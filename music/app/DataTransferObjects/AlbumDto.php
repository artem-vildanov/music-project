<?php

namespace App\DataTransferObjects;

class AlbumDto
{
    public int $id;
    public string $name;
    public string $photoPath;
    public int $likes;
    public int $artistId;
    public array $songs;
}
