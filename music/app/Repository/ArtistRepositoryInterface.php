<?php

namespace App\Repository;

use App\DataTransferObjects\ArtistDto;
use Exception;

interface ArtistRepositoryInterface
{
    public function getById($albumId): ArtistDto|null;

    /**
     * поиск артиста, который управляется пользователем
     * @param $userId
     * @return ArtistDto|null
     */
    public function getByUserId($userId): ArtistDto|null;

    /**
     * поиск любимых артистов пользователя
     * @param $userId
     * @return mixed
     */
    public function getUserFavourites($userId): array;

    public function getAllByGenre($genreId): array;

    public function create(ArtistDto $artistDto): int|false;
}
