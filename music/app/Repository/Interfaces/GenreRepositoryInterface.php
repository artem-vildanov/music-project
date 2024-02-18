<?php

namespace App\Repository\Interfaces;

use App\Models\Genre;

interface GenreRepositoryInterface {

    /**
     * @param int $genreId
     * @return Genre|null
     */
    public function getById(int $genreId): Genre|null;
}
