<?php

use Controller\ProjectController;
use Service\ProjectService;

// Moet ingelogd zijn om deze pagina te kunnen bekijken
if (!AUTH->isLoggedIn()) {
    header('Location: login');
    exit;
}

$errors = [];
$projectService = ProjectService::getInstance();
$projectController = ProjectController::getInstance();
$project = null;

/**
 * Ophalen project.
 * - Als er een projectId in de url is, haal deze dan op en zet deze in de $project variabele, anders is de variabele null.
 * - Als de variabele null is, dan wordt de if statement false.
 * - Als er wel een waarde is in de variabele dan wordt de if statement true.
 */
if ($projectId = $_GET['projectId'] ?? null) {
    // Haal het project op met de $projectId
    $project = $projectService->getProjectById($projectId);
}

// Handeling van request naar logica
$projectController->handleRequest($_POST, $errors);
?>

<h1><?= $project ? 'Edit Project' : 'Create Project' ?></h1>

<form class="form-element" method="post" enctype="multipart/form-data">
    <div class="inputs-container">
        <?php if (!empty($errors)): ?>
            <div class="errors">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if ($project): ?>
            <input type="hidden" name="projectId" value="<?= htmlspecialchars($project->getId()) ?>">
        <?php endif; ?>

        <p class="title-hint">Title: </p>
        <label>
            <input class="title-input" type="text" name="title" placeholder="Title"
                   value="<?= $project ? htmlspecialchars($project->getTitle()) : '' ?>" required>
        </label>

        <p class="description-hint">Description: </p>
        <label>
            <textarea cols="30" rows="15" name="description" placeholder="Description" required><?= $project ? htmlspecialchars($project->getDescription()) : '' ?></textarea>
        </label>

        <?php if ($project && $project->getImage()): ?>
            <div class="edit-image-container">
                <img class="edit-image" src="<?= htmlspecialchars($project->getImage()) ?>" alt="Project Image">
            </div>
        <?php endif; ?>
        <label>
            <input type="file" name="image">
        </label>

        <div class="skills-container">
            <?php
            $selectedSkills = $project && is_array($project->getSkills()) ? $project->getSkills() : [];
            $allSkills = ['HTML', 'CSS', 'JavaScript', 'PHP', 'Java', 'Laravel'];

            foreach ($allSkills as $skill):
                $isChecked = in_array($skill, $selectedSkills) ? 'checked' : '';
                ?>
                <label class="skill">
                    <input type="checkbox" name="skills[]" value="<?= $skill ?>" <?= $isChecked ?>>
                    <span><?= $skill ?></span>
                </label>
            <?php endforeach; ?>
        </div>

        <button class="create-button create-page" type="submit" name="action" value="<?= $project ? 'edit' : 'create' ?>">
            <?= $project ? 'Save changes' : 'Create project' ?>
        </button>
    </div>
</form>
