<?php

namespace Tests\Unit\Services;


use App\Services\Contract\FileStorageServiceInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileStorageServiceTest extends TestCase
{
    protected FileStorageServiceInterface $service;
    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(FileStorageServiceInterface::class);
    }

    public function test_file_upload(): void
    {
        $filePath = $this->uploadFile();

        $this->assertTrue(Storage::has($filePath));
        $this->assertEquals(Storage::getVisibility($filePath), 'public');
    }

    public function test_file_upload_with_additional_path()
    {
        $filePath = $this->uploadFile(additionalPath: 'test');

        $this->assertTrue(Storage::has($filePath));
        $this->assertStringContainsString('test', $filePath);
        $this->assertEquals(Storage::getVisibility($filePath), 'public');
    }

    public function test_remove_file()
    {
        $filePath = $this->uploadFile();
        $this->assertTrue(Storage::has($filePath));
        $this->service->remove($filePath);
        $this->assertFalse(Storage::has($filePath));
    }

    protected function uploadFile($fileName = 'image.png', $additionalPath = ''):string
    {
        $file = UploadedFile::fake()->image($fileName);
        return $this->service->upload($file, $additionalPath);
    }
}
