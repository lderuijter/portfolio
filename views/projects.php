<?php
// Gebruik de juiste namespaces voor de controller en service
use Controller\ProjectController;
use Service\ProjectService;

// Haal de controller en service op
$projectController = ProjectController::getInstance();
$projectService = ProjectService::getInstance();

// Haal de projecten op uit de sessie
$projects = $_SESSION['projects'] ?? [];

// Laat de controller de routing / afhandeling van formulieracties doen
$projectController->handleRoutingRequest($_POST);

// -----------------------------
// Functie om projectgroepen te renderen
// -----------------------------
function renderProjectGroups(array $projectGroups, ProjectController $projectController): void
{
    // Controleer of er projectgroepen zijn
    if (!$projectGroups) {
        return;
    }

    foreach ($projectGroups as $group):
        // Tel hoeveel projecten er in deze specifieke groep zitten (altijd 1, 2 of 3 hoeveel groepen er ook zijn)
        $count = count($group);
        ?>
        <div class="project-container columns-<?= $count ?>">
            <!-- Loop door elk project binnen deze groep -->
            <?php foreach ($group as $project): ?>
                <div class="project">

                    <!-- Projectafbeelding -->
                    <?php if ($project->getImage()): ?>
                        <div class="project-image">
                            <img src="<?= htmlspecialchars($project->getImage()) ?>"
                                 alt="<?= htmlspecialchars($project->getTitle()) ?>">
                        </div>
                    <?php else: ?>
                        <div class="project-image">
                            <img src="assets/images/default.png"
                                 alt="Standaard projectafbeelding">
                        </div>
                    <?php endif; ?>

                    <!-- Projectdetails -->
                    <div class="project-details">

                        <!-- Titel -->
                        <div class="project-title">
                            <h2><?= htmlspecialchars($project->getTitle()) ?></h2>
                        </div>

                        <!-- Beschrijving met 'Lees meer' knop -->
                        <div class="project-description">
                            <?php
                            // Truncate de beschrijving op een bepaalde lengte
                            $fullDescription = $project->getDescription();
                            $maxLength = 100;
                            $shortDescription = $projectController->truncateOnWord($fullDescription, $maxLength);
                            ?>
                            <div class="description-text">
                                <span class="short-description"><?= nl2br(htmlspecialchars($shortDescription)) ?></span>
                                <span class="full-description"><?= nl2br(htmlspecialchars($fullDescription)) ?></span>
                            </div>
                            <?php if (strlen($fullDescription) > $maxLength): ?>
                                <button class="toggle-text">Lees meer</button>
                            <?php endif; ?>
                        </div>

                        <!-- Container voor skills + admin knoppen -->
                        <div class="project-actions">
                            <?php
                            // Maximaal 2 kolommen voor de skills
                            $skills = $project->getSkills() ?? [];
                            $skillCount = min(2, count($skills));
                            ?>
                            <div class="project-skill-container columns-<?= $skillCount ?>">
                                <?php if (empty($skills)): ?>
                                    <div class="errors">
                                        <p>Geen skills geselecteerd!</p>
                                    </div>
                                <?php else: ?>
                                    <?php foreach ($skills as $skill): ?>
                                        <div class="project-skill"><?= htmlspecialchars($skill) ?></div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>

                            <!-- Admin knoppen alleen zichtbaar als student is ingelogd -->
                            <?php if (AUTH->isLoggedIn()): ?>
                                <form method="post">
                                    <!-- Verstuur project-ID als verborgen veld -->
                                    <input name="projectId" type="hidden"
                                           value="<?= htmlspecialchars($project->getId()) ?>">

                                    <div class="admin-buttons">
                                        <!-- Bewerken-knop -->
                                        <button name="action" type="submit" class="edit-button" value="edit">
                                            <i class="fa-solid fa-pen-to-square button-icon"></i>
                                        </button>
                                        <!-- Verwijderen-knop -->
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
    <?php
    endforeach;
}
?>

<h1>Projects</h1>

<?php if (empty($projects)): ?>
    <!-- Toon een melding als er geen projecten zijn -->
    <div class="errors">
        <p>Geen projecten gevonden!</p>
    </div>
<?php endif; ?>

<?php
// Verdeel de projecten in groepen van 3 voor desktop
$projectGroups = array_chunk($projects, 3);
?>

<div class="desktop">
    <?php renderProjectGroups($projectGroups, $projectController); ?>
</div>

<?php
// Voor responsiveness tussen 992px en 692px, verdeel de projecten in groepen van 2
$projectGroupsResponsive = array_chunk($projects, 2);
?>

<div class="tablet">
    <?php renderProjectGroups($projectGroupsResponsive, $projectController); ?>
</div>

<!-- Create knop alleen zichtbaar als student is ingelogd -->
<?php if (AUTH->isLoggedIn()): ?>
    <br>
    <form method="post">
        <button name="action" type="submit" class="create-button" value="create">
            Nieuw project aanmaken
        </button>
    </form>
<?php endif; ?>
