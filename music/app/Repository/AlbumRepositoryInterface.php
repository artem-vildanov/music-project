<?php

namespace App\Repository;

use App\Models\Album;
use PhpParser\Builder;

interface AlbumRepositoryInterface {
    /**
     * @param int $albumId
     * @return Album|null
     */
    public function getById(int $albumId): Album|null;

    /**
     * @param int $artistId
     * @return array<Album>
     */
    public function getAllByArtist(int $artistId): array;

    public function getAllByUser(int $userId);

    public function getAllByGenre(int $genreId);

    /**
     * @param string $name
     * @param string $photoPath
     * @param int $artistId
     * @return int
     */
    public function create(string $name, string $photoPath, int $artistId): int;

}
