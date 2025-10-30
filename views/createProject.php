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
            $projectService->create($_POST);
            break;
        case 'edit':
            $projectService->updateProject($_POST['projectId']);
            break;
        default:
            // onbekende actie handelen
            http_response_code(400);
            echo "Invalid or missing action.";
            break;
    }
}
/* TODO:
 * Wanneer Project niet null is, dan is het een bestaand project wat bewerkt moet worden
 * Wanneer Project null is, dan is het een nieuw project wat aangemaakt moet worden
 * */
?>

<h1>Create projects</h1>

<form>
    <p>Title: </p>
    <label>
        <input type="text" name="title" placeholder="Title">
    </label>
    <p>Description: </p>
    <label>
        <input type="text" name="description" placeholder="Description">
    </label>

    <button name="action" type="submit" value="create">
        Create
    </button>

    <button name="action" type="submit" value="edit">
        Edit
    </button>
</form>
