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

if (isset($_GET['projectId'])) {
    $projectId = $_GET['projectId'];
    $project = $projectService->getProjectById($projectId);
}

// Handeling van request naar logica
$projectController->handleRequest($_POST, $errors);
?>

<h1><?= $project ? 'Edit Project' : 'Create Project' ?></h1>

<?php if (!empty($errors)): ?>
    <div class="errors">
        <?php foreach ($errors as $error): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">
    <?php if ($project): ?>
        <input type="hidden" name="projectId" value="<?= htmlspecialchars($project->getId()) ?>">
    <?php endif; ?>

    <p>Title:</p>
    <label>
        <input type="text" name="title" placeholder="Title"
               value="<?= $project ? htmlspecialchars($project->getTitle()) : '' ?>" required>
    </label>

    <p>Description:</p>
    <label>
        <input type="text" name="description" placeholder="Description"
               value="<?= $project ? htmlspecialchars($project->getDescription()) : '' ?>" required>
    </label>

    <p>Image:</p>
    <?php if ($project && $project->getImage()): ?>
        <div class="edit-image-container">
            <img class="edit-image" src="<?= htmlspecialchars($project->getImage()) ?>" alt="Project Image">
        </div>
        <p>Upload a new image to replace:</p>
    <?php endif; ?>
    <label>
        <input type="file" name="image">
    </label>

    <p>Skills:</p>
    <?php
    $selectedSkills = $project && is_array($project->getSkills()) ? $project->getSkills() : [];
    $allSkills = ['HTML', 'CSS', 'JavaScript', 'PHP', 'Java', 'Laravel'];

    foreach ($allSkills as $skill):
        $isChecked = in_array($skill, $selectedSkills) ? 'checked' : '';
        ?>
        <label class="skill">
            <input type="checkbox" name="skills[]" value="<?= $skill ?>" <?= $isChecked ?>>
            <?= $skill ?>
        </label><br>
    <?php endforeach; ?>

    <button type="submit" name="action" value="<?= $project ? 'edit' : 'create' ?>">
        <?= $project ? 'Save changes' : 'Create project' ?>
    </button>
</form>
