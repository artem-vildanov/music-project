<?php

namespace App\Http\RequestModels;

use Illuminate\Http\UploadedFile;

class CreateAlbumModel
{
    public string $name;
    public UploadedFile $photo;
}
