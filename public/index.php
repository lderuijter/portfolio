<?php
/** @var $base */
require_once __DIR__ . '/config.php';

session_start();

if (isset($_POST['theme'])) {
    $_SESSION['theme'] = $_POST['theme'];
}

$theme = isset($_SESSION['theme']) ? $_SESSION['theme'] : 'dark';

$_SESSION['theme'] = $theme;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= isset($title) ? $title : 'Portfolio' ?></title>
    <link rel="stylesheet" href="<?= $base ?>assets/css/style.css">
    <script src="<?= $base ?>assets/js/script.js" defer></script>
</head>
<body class="<?= $theme ?>">
<main>
    <?php include 'views/components/navbar.php'; ?>
    <?php include 'page.php'; ?>
    <?php include 'views/components/footer.php'; ?>
</main>
</body>
