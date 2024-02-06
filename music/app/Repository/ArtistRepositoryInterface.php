<?php

namespace App\Repository;

use App\DataTransferObjects\ArtistDto;

interface ArtistRepositoryInterface
{
    public function getById($id);

    public function getAllByUser($userId);

    public function getAllByGenre($genreId);

    public function create(ArtistDto $artistDto);
}
