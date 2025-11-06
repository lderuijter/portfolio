<?php

namespace Controller;

use Core\SingletonTrait;
use Exception;
use Service\ProjectService;

class ProjectController
{
    use SingletonTrait;

    private ProjectService $projectService;

    public function __construct()
    {
        // ProjectService singleton ophalen
        $this->projectService = ProjectService::getInstance();
    }

    // Handelt simpele routing-acties af zoals create, edit of delete
    public function handleRoutingRequest(?array $formData): void
    {
        if (!$this->isPostRequest()) {
            return; // Alleen POST-requests verwerken
        }

        $action = $this->getAction($formData);

        // Als action edit of delete is zonder projectId -> return
        if (in_array($action, ['edit', 'delete'], true) && empty($formData['projectId'])) {
            return;
        }

        // Afhandelen van de verschillende acties
        match ($action) {
            'create' => $this->redirect('createProject'),
            'edit'   => $this->redirect('createProject?projectId=' . $formData['projectId']),
            'delete' => $this->handleDelete($formData['projectId']),
            default  => $this->badRequest('Ongeldige of ontbrekende actie.'),
        };
    }

    // Verwerkt het formulier voor create en edit
    public function handleRequest(?array $formData, ?array &$errors): void
    {
        if (!$this->isPostRequest()) {
            return; // Alleen POST-requests verwerken
        }

        $action = $this->getAction($formData);

        try {
            // Actie afhandelen via aparte functies met logica
            match ($action) {
                'create' => $this->handleCreate($formData, $errors),
                'edit'   => $this->handleEdit($action, $formData, $errors),
                default  => $this->badRequest('Ongeldige of ontbrekende actie.'),
            };
        } catch (Exception $e) {
            // Fouten bij acties opvangen en toevoegen aan errors
            $errors[] = $e->getMessage();
        }
    }

    // ====== Public Helpers ======

    // Maak de beschrijving korter en stop alleen op een woord (maximaal 100 karakters)
    public function truncateOnWord($text, $maxLength = 100) {
        if (strlen($text) <= $maxLength) {
            return $text;
        }

        // Knip de tekst af op $maxLength
        $truncated = substr($text, 0, $maxLength);

        // Zorg dat we niet midden in een woord eindigen
        $lastSpace = strrpos($truncated, ' ');
        if ($lastSpace !== false) {
            $truncated = substr($truncated, 0, $lastSpace);
        }

        return $truncated;
    }

    // ====== Private Helpers ======

    // Controleert of het een POST-request is
    private function isPostRequest(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    // Haalt de action uit het formulier
    private function getAction(?array $formData): ?string
    {
        return $formData['action'] ?? null;
    }

    // Stuurt door naar een andere pagina
    private function redirect(string $url): void
    {
        header("Location: $url");
    }

    // Geeft een foutmelding bij een ongeldige actie
    private function badRequest(string $message): void
    {
        http_response_code(400);
        echo $message;
    }

    // Verwijdert een project en redirect naar overzicht
    private function handleDelete(?string $projectId): void
    {
        $this->projectService->deleteProject($projectId);
        $this->redirect('projects');
    }

    // Verwerkt het aanmaken van een nieuw project
    private function handleCreate(array $formData, array &$errors): void
    {
        $this->validateInputs($formData, $errors);

        $newProject = $this->projectService->create($formData);

        if (empty($errors)) {
            $this->projectService->addProject($newProject);
            $this->redirect('projects');
        }
    }

    // Verwerkt het bewerken van een bestaand project
    private function handleEdit(string $action, array $formData, array &$errors): void
    {
        $projectId = $formData['projectId'] ?? null;

        $this->validateInputs($formData, $errors, $projectId, $action);

        // Als er fouten zijn dan return (zodat er niks wordt aangepast als de titel en beschrijving leeg zijn)
        if (!empty($errors)) {
            return;
        }

        $this->projectService->updateProject($projectId, $formData, $errors);

        if (empty($errors)) {
            $this->redirect('projects');
        }
    }

    private function validateInputs(array $formData, array &$errors, ?string $projectId = null, ?string $action = null): void
    {
        // Vereiste velden checken
        if (empty($formData['title']) || empty($formData['description'])) {
            $errors[] = 'Titel en beschrijving zijn verplicht!';
        }

        if ($action === 'edit' && empty($projectId)) {
            $errors[] = 'Project ID is verplicht bij bewerken!';
        }
    }
}
