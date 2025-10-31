<?php

use Service\ProjectService;

$projectService = ProjectService::getInstance();
$projects = $_SESSION['projects'] ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;
    switch ($action) {
        case 'create':
            header("Location: createProject");
            break;
        case 'edit':
            header("Location: createProject?projectId=" . $_POST['projectId']);
            break;
        case 'delete':
            $projectService->deleteProject($_POST['projectId']);
            header("Location: projects");
            break;
        default:
            // onbekende actie handelen
            http_response_code(400);
            echo "Invalid or missing action.";
            break;
    }
}
?>

<h1>Projects page</h1>

<?php foreach ($projects as $project): ?>
    <div class="project">
        <h2><?= htmlspecialchars($project->getTitle()) ?></h2>
        <p><?= htmlspecialchars($project->getDescription()) ?></p>
        <?php foreach ($project->getSkills() ?? [] as $skill): ?>
            <div class="skill">
                <?= htmlspecialchars($skill) ?>
            </div>
        <?php endforeach; ?>
        <?php if (AUTH->isLoggedIn()): ?>
            <div class="admin-buttons">
                <form method="post">
                    <input name="projectId" type="hidden" value="<?= htmlspecialchars($project->getId()) ?>">
                    <button name="action" type="submit" class="edit-button" value="edit">Edit</button>
                    <button name="action" type="submit" class="delete-button" value="delete">Delete</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

<?php if (AUTH->isLoggedIn()): ?>
    <br>
    <form method="post">
        <button name="action" type="submit" class="create-button" value="create">Create new project</button>
    </form>
<?php endif; ?>
