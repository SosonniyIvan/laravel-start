<?php

namespace App\Services\Interface;



use Illuminate\Http\UploadedFile;

interface FileStorageServiceInterface
{
    public function upload(UploadedFile|string $file, string $additionalPath = ''): string;

    public function remove(string $filePath): void;
}
