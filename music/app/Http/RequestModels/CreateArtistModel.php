<?php

namespace App\Http\RequestModels;

use Illuminate\Http\UploadedFile;

class CreateArtistModel
{
    public string $name;
    public UploadedFile $photo;
}
