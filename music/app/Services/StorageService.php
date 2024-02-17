<?php

declare(strict_types=1);

namespace App\Services;

use Aws\S3\S3Client;
use Illuminate\Http\UploadedFile;

class StorageService
{
    public function storeAudio(string $albumFolderId, UploadedFile $file): string
    {
        $fileName = uniqid(more_entropy: true);
        $filePath = "{$albumFolderId}/{$fileName}.mp3";

        $this->getClient()->putObject(
            [
                'Bucket' => 'audio',
                'Key' => $filePath,
                'Body' => $file->getContent(),
            ]
        );

        $this->getClient()->waitUntil('ObjectExists', ['Bucket' => 'audio', 'Key' => $filePath]);

        return $filePath;
    }

    public function storeAlbumPhoto(UploadedFile $file): string|null
    {
        return $this->storePhoto('album', $file);
    }

    public function storeArtistPhoto(UploadedFile $file): string|null
    {
        return $this->storePhoto('artist', $file);
    }

    /**
     * @param string $fileType 'artist' || 'album'
     * @param UploadedFile $file
     * @return string|false
     */
    private function storePhoto(string $fileType, UploadedFile $file): string|null
    {
        $fileName = uniqid(more_entropy: true);
        $filePath = "{$fileType}/{$fileName}.png";


        $this->getClient()->putObject(
            [
                'Bucket' => 'photo',
                'Key' => $filePath,
                'Body' => $file->getContent(),
            ]
        );

        $this->getClient()->waitUntil('ObjectExists', ['Bucket' => 'photo', 'Key' => $filePath]);

        return $filePath;
    }

    private function getClient(): S3Client
    {
        return new S3Client(config('aws'));
    }

}
