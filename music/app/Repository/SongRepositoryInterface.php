<?php

namespace App\Repository;

use App\DataTransferObjects\AlbumDto;
use App\DataTransferObjects\SongDto;

interface SongRepositoryInterface {

    public function getById($songId): SongDto|null;

    public function createMultiple(array $songsDtoCollection): array|false;

    public function create(SongDto $songDto): int|false;

    public function delete(SongDto $songDto): bool;

    public function update(SongDto $songDto): bool;

}
