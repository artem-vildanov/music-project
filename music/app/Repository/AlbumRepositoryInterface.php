<?php

namespace App\Repository;

interface AlbumRepositoryInterface {

    public function getById($albumId);

    public function getAllByArtist($artistId);

    public function getAllByUser($userId);

    public function getAllByGenre($genreId);

}
