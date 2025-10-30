<?php

namespace Service;

use Classes\Project;

class ProjectService
{
    private static ?ProjectService $instance = null;

    private array $projects;

    public function __construct()
    {
        // initialiseren van de projects array door dit uit de session te halen als het undefined is dan lege array
        $this->projects = $_SESSION['projects'] ?? [];
    }

    // functie om een enkele instantie van de ProjectService te maken singleton pattern
    public static function getInstance(): ?ProjectService
    {
        if (self::$instance === null) {
            self::$instance = new ProjectService();
        }
        return self::$instance;
    }

    public function getProjectById($projectId): ?Project
    {
        $filtered = array_filter($this->projects, function ($p) use ($projectId) {
            return $p->getId() === $projectId;
        });

        $projects = array_values($filtered); // herindexeren van de sleutels
        return $projects[0] ?? null;
    }

    public function create($formData): ?Project
    {
        $project = new Project();
        $this->applyForm($project, $formData);
        return $project;
    }

    public function addProject(Project $project): void
    {
        $this->projects[] = $project;
        $this->applySession();
    }

    public function updateProject($formData): void
    {
        foreach ($this->projects as $project) {
            if ($project->getId() === $formData['projectId']) {
                $this->applyForm($project, $formData);
                break;
            }
        }
        $this->applySession();
    }

    public function deleteProject($projectId): void
    {
        $this->projects = array_filter($this->projects, function ($p) use ($projectId) {
            return $p->getId() !== $projectId;
        });
        $this->applySession();
    }

    public function applyForm(Project $project, $formData): ?Project
    {
        $project->setTitle($formData['title']);
        $project->setDescription($formData['description']);
        $project->setSkills($formData['skills'] ?? null);
        $project->setImage($formData['image'] ?? null);
        return $project;
    }

    public function applySession(): void
    {
        $_SESSION['projects'] = $this->projects;
    }

    public function getProjects(): array
    {
        return $_SESSION['projects'];
    }

    public function setProjects(array $projects): void
    {
        $this->projects = $projects;
    }
}
