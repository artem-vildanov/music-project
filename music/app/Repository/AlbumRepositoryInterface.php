<?php

namespace App\Repository;

use App\DataTransferObjects\AlbumDto;

interface AlbumRepositoryInterface {

    public function getById($albumId): AlbumDto|null;

    public function getAllByArtist($artistId);

    public function getAllByUser($userId);

    public function getAllByGenre($genreId);

    /**
     * save album entity in db
     * save songs entities in db
     * @return int album_id
     */
    //TODO можно ли сохранять в одном методе репозитория сразу несколько сущностей? Музыка и альбомы
    public function create(AlbumDto $albumDto): int|false;

}
