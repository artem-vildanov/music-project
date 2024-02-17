<?php

namespace App\Models;

enum Genres: int
{
    case Pop = 1;
    case Rock = 2;
    case Rap = 4;
    case New = 8;

}
