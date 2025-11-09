<?php
// constant base path aanmaken voor require_once
define('BASE_PATH', dirname(__FILE__));

require_once BASE_PATH . '/autoload.php';

use Controller\AuthController;

// page moet globaal gebruikt kunnen worden en uit de GET-parameter gehaald worden
define('PAGE', $_GET['page'] ?? 'home');
// auth moet globaal gebruikt kunnen worden voor meerdere pagina's
define('AUTH', AuthController::getInstance());

// gebruikte protocol ophalen
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
// domein ophalen
$host = $_SERVER['HTTP_HOST'];
// de juiste directory ophalen na de slash
$scriptDir = dirname($_SERVER['SCRIPT_NAME']); // e.g., /portfolio
// constant base url aanmaken voor href en src
define('BASE_URL', $protocol . $host . $scriptDir . '/');

// session starten
session_start();

// check of een thema is meegegeven via POST vanuit script.js
if (isset($_POST['theme'])) {
    // sla het thema op in de sessie
    $_SESSION['theme'] = $_POST['theme'];
}

// check of het thema bestaat in de sessie, als dat zo is, pak dat thema, anders default dark
$theme = $_SESSION['theme'] ?? 'dark';

// sla het thema opnieuw op in de sessie zodat dit gebruikt kan worden in themeSlider.php
$_SESSION['theme'] = $theme;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Pak de title uit de page.php afhankelijk van de pagina -->
    <title><?= $title ?? 'Portfolio' ?></title>

    <!-- CSS-bestanden inladen van aangegeven folders -->
    <!-- Eerst de componenten -->
    <?php load_css_folder('assets/css/components/'); ?>
    <!-- Daarna de pagina's -->
    <?php load_css_folder('assets/css/pages'); ?>

    <!-- Logo favicon -->
    <link rel="icon" type="image/png" href="assets/images/favicon.png">

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster+Two:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

    <!-- Font Awesome inladen voor de icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- Gebruik base om de juiste javascript te pakken -->
    <script src="<?= BASE_URL ?>assets/js/script.js" defer></script>
</head>
<!-- Gebruik de theme variabele zodat de body zich aan past aan de hand van de toggle -->
<body class="<?= $theme ?>">
<main>
    <!-- Include alle componenten -->
    <?php include 'views/components/navbar.php'; ?>
    <?php include 'views/components/logo.php'; ?>
    <?php include 'page.php'; ?>
    <?php include 'views/components/footer.php'; ?>
</main>
</body>
