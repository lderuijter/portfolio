<?php
// de base variabele wordt altijd opgehaald uit de config.php
/** @var $base */
require_once __DIR__ . '/config.php';

// session starten
session_start();

// check of een thema is meegegeven via POST vanuit script.js
if (isset($_POST['theme'])) {
    // sla het thema op in de sessie
    $_SESSION['theme'] = $_POST['theme'];
}

// check of het thema bestaat in de sessie, als dat zo is, pak dat thema, anders default dark
$theme = isset($_SESSION['theme']) ? $_SESSION['theme'] : 'dark';

// sla het thema opnieuw op in de sessie zodat dit gebruikt kan worden in themeSlider.php
$_SESSION['theme'] = $theme;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Pak de title uit de page.php afhankelijk van de pagina-->
    <title><?= isset($title) ? $title : 'Portfolio' ?></title>
    <!-- Gebruik base om de juiste css te pakken -->
    <link rel="stylesheet" href="<?= $base ?>assets/css/style.css">
    <!-- Font Awesome inladen voor de icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- Gebruik base om de juiste javascript te pakken -->
    <script src="<?= $base ?>assets/js/script.js" defer></script>
</head>
<!-- Gebruik de theme variabele zodat de body zich aan past aan de hand van de toggle -->
<body class="<?= $theme ?>">
<main>
    <!-- Include alle componenten -->
    <?php include 'views/components/navbar.php'; ?>
    <?php include 'page.php'; ?>
    <?php include 'views/components/footer.php'; ?>
</main>
</body>
