<?php

use Controller\ProjectController;
use Service\ProjectService;

$projectController = ProjectController::getInstance();
$projectService = ProjectService::getInstance();
$projects = $_SESSION['projects'] ?? [];

// Handeling van request naar andere pagina's
$projectController->handleRoutingRequest($_POST);
?>

<h1>Projects page</h1>

<?php if (empty($projects)): ?>
    <div class="errors">
        <p>No projects found!</p>
    </div>
<?php endif; ?>

<?php $projectCount = min(3, count($projects)); ?>
<div class="project-container columns-<?= $projectCount ?>">
    <?php foreach ($projects as $project): ?>
        <div class="project">
            <?php if ($project->getImage()): ?>
                <div class="project-image">
                    <img src="<?= htmlspecialchars($project->getImage()) ?>"
                         alt="<?= htmlspecialchars($project->getTitle()) ?>">
                </div>
            <?php else: ?>
                <div class="project-image">
                    <img src="assets/images/default.png"
                         alt="Default project image">
                </div>
            <?php endif; ?>
            <div class="project-details">
                <div class="project-title">
                    <h2><?= htmlspecialchars($project->getTitle()) ?></h2>
                </div>
                <div class="project-description">
                    <p><?= htmlspecialchars($project->getDescription()) ?></p>
                </div>
                <div class="project-actions">
                    <?php $skillCount = min(2, count($project->getSkills() ?? [])); ?>
                    <div class="project-skill-container columns-<?= $skillCount ?>">
                        <?php if (empty($project->getSkills())): ?>
                            <div class="no-content">
                                <p>No skills selected!</p>
                            </div>
                        <?php endif; ?>
                        <?php foreach ($project->getSkills() ?? [] as $skill): ?>
                            <div class="project-skill">
                                <?= htmlspecialchars($skill) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if (AUTH->isLoggedIn()): ?>
                        <form method="post">
                            <input name="projectId" type="hidden" value="<?= htmlspecialchars($project->getId()) ?>">
                            <div class="admin-buttons">
                                <button name="action" type="submit" class="edit-button" value="edit">
                                    <i class="fa-solid fa-pen-to-square button-icon"></i>
                                </button>
                                <button name="action" type="submit" class="delete-button" value="delete">
                                    <i class="fa-solid fa-trash button-icon"></i>
                                </button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php if (AUTH->isLoggedIn()): ?>
    <br>
    <form method="post">
        <button name="action" type="submit" class="create-button" value="create">Create new project</button>
    </form>
<?php endif; ?>
