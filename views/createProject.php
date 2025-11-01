<?php

use Service\ProjectService;

// Moet ingelogd zijn om deze pagina te kunnen bekijken
if (!AUTH->isLoggedIn()) {
    header('Location: login');
    exit;
}

$errors = [];
$projectService = ProjectService::getInstance();
$project = null;

if (isset($_GET['projectId'])) {
    $projectId = $_GET['projectId'];
    $project = $projectService->getProjectById($projectId);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;

    try {
        switch ($action) {
            case 'create':
                if (empty($_POST['title']) || empty($_POST['description'])) {
                    $errors[] = 'Title and description are required!';
                    break;
                }

                $newProject = $projectService->create($_POST);

                if (empty($errors)) {
                    $projectService->addProject($newProject);
                    header('Location: projects');
                    exit;
                }
                break;

            case 'edit':
                if (!isset($_POST['projectId'])) {
                    $errors[] = 'Project ID is required for editing.';
                    break;
                }

                $projectService->updateProject($_POST['projectId'], $_POST, $errors);

                if (empty($errors)) {
                    header('Location: projects');
                    exit;
                }
                break;

            default:
                http_response_code(400);
                echo "Invalid or missing action.";
                exit;
        }
    } catch (Exception $e) {
        $errors[] = $e->getMessage();
    }
}
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
        <img class="edit-project-image" src="<?= htmlspecialchars($project->getImage()) ?>" alt="Project Image">
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
