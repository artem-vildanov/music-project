<?php

namespace App\Repository;

use App\DataTransferObjects\AlbumDto;
use App\DataTransferObjects\SongDto;
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

    public function update(string $name, string $photoPath, string $musicPath, int $albumId): bool;

}
