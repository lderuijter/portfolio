<?php

use Service\ProjectService;

// Op de pagina van het aanmaken of bewerken van een project moet de gebruiker ingelogd zijn
if (!AUTH->isLoggedIn()) {
    header('Location: login');
}

$projectService = ProjectService::getInstance();
$project = null;

if (isset($_GET['projectId'])) {
    $projectId = $_GET['projectId'];
    $project = $projectService->getProjectById($projectId);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;
    switch ($action) {
        case 'create':
            if (empty($_POST['title']) || empty($_POST['description'])) {
                header("Location: createProject?error=1");
                exit;
            }
            $newProject = $projectService->create($_POST);
            $projectService->addProject($newProject);
            break;
        case 'edit':
            if (isset($_POST['projectId'])) {
                $projectService->updateProject($_POST);
            }
            break;
        default:
            // onbekende actie handelen
            http_response_code(400);
            echo "Invalid or missing action.";
            break;
    }
    header("Location: projects");
}
?>

<h1>Create projects</h1>

<?php if (isset($_GET['error'])): ?>
    <div class="missing-input">
        <p>Title and description are required!</p>
    </div>
<?php endif; ?>

<form method="post">
    <?php if ($project): ?>
        <input type="hidden" name="projectId" value="<?= htmlspecialchars($project->getId()) ?>">
    <?php endif; ?>
    <p>Title: </p>
    <label>
        <input type="text" name="title" placeholder="Title" value="<?= $project ? $project->getTitle() : '' ?>"
               required>
    </label>
    <p>Description: </p>
    <label>
        <input type="text" name="description" placeholder="Description"
               value="<?= $project ? $project->getDescription() : '' ?>" required>
    </label>

    <p>Skills: </p>
    <?php
    $selectedSkills = [];

    if ($project) {
        if (!empty($project->getSkills()) && is_array($project->getSkills())) {
            $selectedSkills = $project->getSkills();
        }
    }

    $allSkills = ['HTML', 'CSS', 'JavaScript', 'PHP', 'Java', 'Laravel'];

    foreach ($allSkills as $skill) {
        $isChecked = in_array($skill, $selectedSkills) ? 'checked' : '';
        echo "
            <label class='skill'>
                <input type='checkbox' name='skills[]' value='$skill' $isChecked>
                $skill
            </label>
            <br>
        ";
    }
    ?>
    <button name="action" type="submit" value="<?= $project ? 'edit' : 'create' ?>">
        <?= $project ? 'Save changes' : 'Create project' ?>
    </button>
</form>
