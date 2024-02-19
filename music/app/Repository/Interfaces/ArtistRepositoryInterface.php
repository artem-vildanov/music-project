<?php

namespace App\Repository\Interfaces;

use App\Models\Artist;

interface ArtistRepositoryInterface
{
    /**
     * @param int $artistId
     * @return Artist|null
     */
    public function getById(int $artistId): Artist|null;

    /**
     * поиск артиста, который управляется пользователем
     * @param int $userId
     * @return Artist|null
     */
    public function getByUserId(int $userId): Artist|null;

    /**
     * поиск любимых артистов пользователя
     * @param $userId
     * @return array
     */
    public function getUserFavourites($userId): array;

    /**
     * @param $genreId
     * @return array
     */
    public function getAllByGenre($genreId): array;


    /**
     * @param string $name
     * @param string $photoPath
     * @param int $userId
     * @return int
     */
    public function create(
        string $name,
        string $photoPath,
        int $userId
    ): int;

    public function update(
        int $artistId,
        string $name
    ): bool;

    public function delete(int $artistId): bool;
}
