<?php

namespace Service;

use Core\SingletonTrait;
use Exception;

class UploadService
{
    use SingletonTrait;

    private string $uploadDir;
    private array $allowedTypes = ['image/jpeg', 'image/png'];
    private int $maxFileSize = 2 * 1024 * 1024; // 2 MB

    private function __construct()
    {
        $this->uploadDir = BASE_PATH . '/assets/uploads/';

        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }

    /**
     * @throws Exception
     */
    public function uploadFile(array $file): ?string
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Error uploading file: " . $file['error']);
        }

        if (!in_array($file['type'], $this->allowedTypes)) {
            throw new Exception("Invalid file type. Allowed: JPG, PNG.");
        }

        if ($file['size'] > $this->maxFileSize) {
            throw new Exception("File size exceeds the maximum limit.");
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = uniqid('uploaded-image_', true) . '.' . $extension;
        $targetPath = $this->uploadDir . $fileName;

        // upload het bestand van temporary dir naar de uploads map
        move_uploaded_file($file['tmp_name'], $targetPath);

        return 'assets/uploads/' . $fileName;
    }

    public function deleteFile(?string $relativePath): void
    {
        if (!$relativePath) {
            return;
        }

        $absolutePath = BASE_PATH . '/' . ltrim($relativePath, '/');

        if (file_exists($absolutePath)) {
            unlink($absolutePath);
        }
    }
}
