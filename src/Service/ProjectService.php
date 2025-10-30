<?php

namespace Service;

use Classes\Project;

class ProjectService
{
    private static ?ProjectService $instance = null;

    private array $projects = [];

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
        return array_filter($this->projects, function ($p) use ($projectId) {
            return $p->getId() === $projectId;
        })[0] ?? null;
    }

    public function create($formData): ?Project
    {
        $project = new Project();
        $project->setTitle($formData['title']);
        $project->setDescription($formData['description']);
        $project->setSkills($formData['skills'] ?? null);
        $project->setImage($formData['image'] ?? null);
        return $project;
    }

    public function addProject(Project $project): void
    {
        $this->projects[] = $project;
        $this->applySession();
    }

    public function updateProject($projectId): void
    {
        foreach ($this->projects as $key => $project) {
            if ($project->getId() === $projectId) {
                $this->projects[$key] = $project;
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

    public function applySession(): void
    {
        $_SESSION['projects'] = $this->projects;
    }

    public function getProjects(): array
    {
        return $this->projects;
    }

    public function setProjects(array $projects): void
    {
        $this->projects = $projects;
    }
}
