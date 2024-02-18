<?php

namespace App\Repository;

use App\Models\Genre;

class GenreRepository implements Interfaces\GenreRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function getById(int $genreId): Genre|null
    {
        return Genre::query()->find($genreId);
    }
}
