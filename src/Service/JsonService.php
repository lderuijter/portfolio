<?php

namespace Service;

use Core\SingletonTrait;
use Classes\Project;

class JsonService
{
    use SingletonTrait;

    /**
     * Laad projecten uit JSON-bestand
     * - Controleert of bestand bestaat
     * - Decodeert JSON
     * - Controleert op corruptie
     * - Zet de array om naar Project-objecten
     */
    public function loadFromJson($filePath): ?array
    {
        if (!file_exists($filePath)) {
            return null;
        }

        $json = file_get_contents($filePath);
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
     * Converteer Project-objecten naar array en sla op in JSON
     */
    public function saveToFile(array $projects, string $filePath): void
    {
        $data = array_map([$this, 'projectToArray'], $projects);
        file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));
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
}
