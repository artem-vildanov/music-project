<?php

namespace App\Repository;

use App\DataTransferObjects\SongDto;

class SongRepository implements SongRepositoryInterface
{
    /**
     * @param $songId
     * @return SongDto|null
     */
    public function getById($songId): SongDto|null
    {
        // TODO: Implement getById() method.
    }

    public function createMultiple(array $songsDtoCollection): array|false
    {
        foreach ($songsDtoCollection as $songDto)
        {

        }
    }

    /**
     * @param SongDto $songDto
     * @return int|false
     */
    public function create(SongDto $songDto): int|false
    {
        // TODO: Implement create() method.
    }

    /**
     * @param SongDto $songDto
     * @return bool
     */
    public function delete(SongDto $songDto): bool
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param SongDto $songDto
     * @return bool
     */
    public function update(SongDto $songDto): bool
    {
        // TODO: Implement update() method.
    }
}
