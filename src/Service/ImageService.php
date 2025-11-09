<?php

namespace Service;

use Core\SingletonTrait;
use Exception;

class ImageService
{
    use SingletonTrait;

    // Map waarin upload afbeeldingen worden opgeslagen
    private string $uploadDir;

    // Toegestane bestandstypen voor upload
    private array $allowedTypes = ['image/jpeg', 'image/png'];

    // Maximale bestandsgrootte (2 MB)
    private int $maxFileSize = 2 * 1024 * 1024;

    private function __construct()
    {
        // Stel de upload-map in op /assets/uploads/ binnen het project
        $this->uploadDir = BASE_PATH . '/assets/uploads/';

        // Controleer of de map bestaat, maak deze aan als dat niet zo is
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }

    /**
     * Upload een afbeelding en retourneer het relatieve pad.
     *
     * @param array $file Het uploadbestand (zoals uit $_FILES[])
     * @return string|null Het relatieve pad naar de afbeelding of null bij fout
     * @throws Exception Wanneer er iets misgaat bij het uploaden
     */
    public function uploadFile(array $file): ?string
    {
        // Controleer of er geen fout is opgetreden
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Fout bij het uploaden: " . $file['error']);
        }

        // Controleer of het bestandstype toegestaan is
        if (!in_array($file['type'], $this->allowedTypes)) {
            throw new Exception("Ongeldig bestandstype. Alleen JPG en PNG zijn toegestaan.");
        }

        // Controleer of het bestand niet te groot is
        if ($file['size'] > $this->maxFileSize) {
            throw new Exception("Bestand is te groot. Maximale grootte is 2 MB.");
        }

        // Haal de extensie op (bijvoorbeeld jpg of png)
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);

        // Genereer een unieke bestandsnaam om conflicten te voorkomen
        $fileName = uniqid('uploaded-image_', true) . '.' . $extension;

        // Volledig pad naar de uploadlocatie
        $targetPath = $this->uploadDir . $fileName;

        // Verplaats het uploadbestand van de tijdelijke map naar de uploads-map
        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            // Als het uploaden mislukt geef dan een foutmelding terug
            throw new Exception("Fout bij het uploaden van het bestand.");
        }

        // Geef het relatieve pad terug
        return 'assets/uploads/' . $fileName;
    }

    /**
     * Verwijder een afbeelding
     *
     * @param string $relativePath Het relatieve pad naar de afbeelding
     */
    public function deleteFile(string $relativePath): void
    {
        // Stop als er geen pad is opgegeven
        if (!$relativePath) {
            return;
        }

        // Bepaal het volledige pad
        $absolutePath = BASE_PATH . '/' . ltrim($relativePath, '/');

        // Verwijder het bestand als het bestaat
        if (file_exists($absolutePath)) {
            unlink($absolutePath);
        }
    }
}
