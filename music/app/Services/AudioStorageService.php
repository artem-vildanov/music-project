<?php

declare(strict_types=1);

namespace App\Services;

use Aws\S3\S3Client;
use Illuminate\Http\UploadedFile;

class AudioStorageService
{
    public function saveAudio(string $albumFolderId, UploadedFile $file): string|null
    {
        $fileName = uniqid(more_entropy: true);
        $filePath = "{$albumFolderId}/{$fileName}.mp3";

        return $this->storeAudio($filePath, $file);
    }

    public function updateAudio(string $filePath, UploadedFile $file): bool
    {
        return (bool)$this->storeAudio($filePath, $file);
    }

    public function deleteAudio(string $filePath): bool
    {
        $result = $this->getClient()->deleteObject([
            'Bucket' => 'audio',
            'Key' => $filePath,
        ]);

        $statusCode = $result['@metadata']['statusCode'];

        return $statusCode === 204;
    }

    private function storeAudio(string $filePath, UploadedFile $file): string|null
    {
        $result = $this->getClient()->putObject(
            [
                'Bucket' => 'audio',
                'Key' => $filePath,
                'Body' => $file->getContent(),
            ]
        );

        // $this->getClient()->waitUntil('ObjectExists', ['Bucket' => 'audio', 'Key' => $filePath]);

        $statusCode = $result['@metadata']['statusCode'];

        return $statusCode === 200 ? $filePath : null;
    }


    private function getClient(): S3Client
    {
        return new S3Client(config('aws'));
    }

}
