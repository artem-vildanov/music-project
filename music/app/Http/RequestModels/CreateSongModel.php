<?php

namespace App\Http\RequestModels;

use Illuminate\Http\UploadedFile;

class CreateSongModel
{
    public string $name;
    public UploadedFile $music;
}
