<?php

namespace Service;

use Core\SingletonTrait;

use Classes\Project;
use Exception;

class ProjectService
{
    use SingletonTrait;
    // Array met projecten
    private array $projects;
    // Path naar JSON-bestand
    private string $jsonFilePath;
    // Service classes
    private ImageService $imageService;
    private JsonService $jsonService;

    public function __construct()
    {
        // Start sessie als deze nog niet actief is
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->imageService = ImageService::getInstance();
        $this->jsonService = JsonService::getInstance();

        $this->jsonFilePath = BASE_PATH . '/projects.json';

        // Laad projecten: JSON is leidend hierin
        $this->projects = $this->loadProjects();
    }

    /**
     * Ophalen projecten.
     * - Haal ze eerst uit het JSON-bestand.
     * - Als er geen projecten zijn, maak een lege lijst en sla die op.
     * - Zet de projecten ook in de sessie zodat de applicatie ze direct kan gebruiken.
     *
     * @return Project[] Lijst van Project-objecten
     */
    private function loadProjects(): array
    {
        $projects = $this->jsonService->loadFromJson($this->jsonFilePath) ?? [];

        if (empty($projects)) {
            $this->jsonService->saveToFile($projects, $this->jsonFilePath);
        }

        // Zet projecten in de sessie
        $_SESSION['projects'] = $projects;

        return $projects;
    }

    /**
     * Vul een Project-object met formulierdata
     * - Skills worden altijd als array gezet, of null als niet geselecteerd
     * - Image kan null zijn
     */
    public function applyForm(Project $project, array $formData): ?Project
    {
        $project->setTitle($formData['title']);
        $project->setDescription($formData['description']);

        // Verwerk skills: array of null
        $skills = $formData['skills'] ?? null;
        if ($skills !== null && !is_array($skills)) {
            $skills = [$skills]; // fallback voor onverwachte string
        }
        $project->setSkills($skills);

        if (!empty($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $this->handleImage($project, $_FILES['image'], $errors);
        }

        return $project;
    }

    /**
     * handleImage: zorgt ervoor dat de afbeelding wordt opgeslagen of verwijderd en vervangen
     */
    public function handleImage(Project $project, ?array $file, ?array &$errors = []): void
    {
        if (empty($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return;
        }

        try {
            $path = $this->imageService->uploadFile($file);

            if ($image = $project->getImage()) {
                $this->imageService->deleteFile($image);
            }

            $project->setImage($path);
        } catch (Exception $e) {
            $errors[] = $e->getMessage();
        }
    }

    /**
     * Sync projecten: sla op in sessie en JSON-bestand
     * - Belangrijk: hiermee blijven sessie en bestand altijd up-to-date
     */
    private function sync(): void
    {
        $_SESSION['projects'] = $this->projects;
        $this->jsonService->saveToFile($this->projects, $this->jsonFilePath);
    }

    /**
     * Maak een nieuw Project-object aan en vul met formulierdata
     */
    public function create(array $formData): ?Project
    {
        $project = new Project();
        $this->applyForm($project, $formData);
        return $project;
    }

    /**
     * Voeg een project toe
     * - Wordt toegevoegd aan array
     * - Sessie en JSON worden gesynchroniseerd
     */
    public function addProject(Project $project): void
    {
        $this->projects[] = $project;
        $this->sync();
    }

    /**
     * Update een bestaand project
     * - Past formulierdata toe
     * - Sync sessie en JSON
     */
    public function updateProject(string $projectId, array $formData, ?array &$errors = []): void
    {
        if (!$projectToUpdate = $this->getProjectById($projectId)) {
            $errors[] = 'Project not found.';
        }
        $this->applyForm($projectToUpdate, $formData);
        $this->sync();
    }

    /**
     * Verwijder een project
     * - Filtert project op ID
     * - Sync sessie en JSON
     */
    public function deleteProject(string $projectId): void
    {
        $imageService = ImageService::getInstance();

        $this->projects = array_filter($this->projects, function ($p) use ($projectId, $imageService) {
            if ($p->getId() === $projectId) {
                // Verwijder afbeelding als deze bestaat
                if ($p->getImage() !== null) {
                    $imageService->deleteFile($p->getImage());
                }
                return false; // false zodat het project wordt verwijderd
            }
            return true; // true zodat de andere projecten blijven
        });

        $this->sync();
    }


    /**
     * Zoek een project op ID
     */
    public function getProjectById(string $projectId): ?Project
    {
        // Filter projecten op ID wanneer deze matched met project ID
        $filtered = array_filter($this->projects, fn($p) => $p->getId() === $projectId);
        // Herindexeer array
        $projects = array_values($filtered);
        // Haal de eerste waarde op of null als er geen project gevonden is
        return $projects[0] ?? null;
    }
}
