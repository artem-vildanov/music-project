<?php

namespace App\DataTransferObjects;

class SongDto
{
    public int $id;
    public string $name;
    public string $photoPath;
    public string $musicPath;
    public int $likes;
}
