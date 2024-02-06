<?php

namespace App\Repository;

interface ArtistRepositoryInterface
{
    public function getById($id);

    public function getAllByUser($userId);

    public function getAllByGenre($genreId);
}
