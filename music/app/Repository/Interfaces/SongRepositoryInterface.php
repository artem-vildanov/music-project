<?php

namespace App\Repository\Interfaces;

use App\Models\Song;

interface SongRepositoryInterface {
    /**
     * @param int $songId
     * @return Song|null
     */
    public function getById(int $songId): Song|null;

    /**
     * @param int $albumId
     * @return array<Song>s
     */
    public function getAllByAlbum(int $albumId): array;

    public function create(string $name, string $photoPath, string $musicPath, int $albumId): int;

    public function delete(int $songId): bool;

    public function update(int $songId, string $name, string $musicPath, string $photoPath): bool;

}
