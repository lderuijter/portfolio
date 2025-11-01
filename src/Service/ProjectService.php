<?php

namespace Service;

use Core\SingletonTrait;

use Classes\Project;
use Exception;

class ProjectService
{
    use SingletonTrait;
    private array $projects;
    private string $filePath;

    public function __construct()
    {
        // Start sessie als deze nog niet actief is
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->filePath = BASE_PATH . '/projects.json';

        // Laad projecten: eerst sessie, dan JSON, anders lege array
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
        $projects = $this->loadFromJson() ?? [];

        if (empty($projects)) {
            $this->saveToFile($projects);
        }

        $_SESSION['projects'] = $projects;

        return $projects;
    }


    /**
     * Laad projecten uit JSON-bestand
     * - Controleert of bestand bestaat
     * - Decodeert JSON
     * - Controleert op corruptie
     * - Zet de array om naar Project-objecten
     */
    private function loadFromJson(): ?array
    {
        if (!file_exists($this->filePath)) {
            return null;
        }

        $json = file_get_contents($this->filePath);
        $data = json_decode($json, true);

        // Als JSON corrupt is, geef lege array terug i.p.v. fouten
        if (json_last_error() !== JSON_ERROR_NONE) {
            return [];
        }

        if (empty($data)) {
            return null;
        }

        // Converteer elk item naar Project-object
        return array_map([$this, 'arrayToProject'], $data);
    }

    /**
     * Vul een Project-object met formulierdata
     * - Skills worden altijd als array gezet, of null als niet geselecteerd
     * - Image kan null zijn (TODO: image upload)
     */
    public function applyForm(Project $project, array $formData): ?Project
    {
        $project->setTitle($formData['title']);
        $project->setDescription($formData['description']);

        // Verwerk skills: altijd array of null
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

    public function handleImage(Project $project, ?array $file, ?array &$errors = []): void
    {
        $uploadService = UploadService::getInstance();

        if (empty($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return;
        }

        try {
            $path = $uploadService->uploadFile($file);

            if ($image = $project->getImage()) {
                $uploadService->deleteFile($image);
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
        $this->saveToFile();
    }

    /**
     * Converteer Project-objecten naar array en sla op in JSON
     */
    private function saveToFile(?array $projects = null): void
    {
        $data = array_map([$this, 'projectToArray'], $projects ?? $this->projects);
        file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT));
    }

    /**
     * Zet Project-object om naar array
     */
    private function projectToArray(Project $project): array
    {
        return [
            'id' => $project->getId(),
            'title' => $project->getTitle(),
            'description' => $project->getDescription(),
            'skills' => $project->getSkills(),
            'image' => $project->getImage(),
        ];
    }

    /**
     * Zet array om naar Project-object
     * - Belangrijk bij het inlezen uit JSON
     */
    private function arrayToProject(array $data): Project
    {
        $project = new Project();
        $project->setId($data['id']);
        $project->setTitle($data['title']);
        $project->setDescription($data['description']);
        $project->setSkills($data['skills'] ?? null);
        $project->setImage($data['image'] ?? null);
        return $project;
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
        $uploadService = UploadService::getInstance();

        $this->projects = array_filter($this->projects, function ($p) use ($projectId, $uploadService) {
            if ($p->getId() === $projectId) {
                // Verwijder afbeelding als deze bestaat
                if ($p->getImage() !== null) {
                    $uploadService->deleteFile($p->getImage());
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
        $filtered = array_filter($this->projects, fn($p) => $p->getId() === $projectId);
        $projects = array_values($filtered);
        return $projects[0] ?? null;
    }

    /**
     * Geef alle projecten terug
     */
    public function getProjects(): array
    {
        return $this->projects;
    }

    /**
     * Stel alle projecten in (en sync)
     */
    public function setProjects(array $projects): void
    {
        $this->projects = $projects;
        $this->sync();
    }
}
