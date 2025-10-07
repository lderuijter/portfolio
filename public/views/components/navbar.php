<?php
if (isset($_POST['theme'])) {
    $_SESSION['theme'] = $_POST['theme'];
}
$theme = isset($_SESSION['theme']) ? $_SESSION['theme'] : 'dark';

if (!isset($_SESSION['theme'])) {
    $_SESSION['theme'] = $theme;
}

$themeState = $theme === 'light' ? 'checked' : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= isset($title) ? $title : 'Portfolio' ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/script.js" defer></script>
</head>
<body class="<?= $theme ?>">
<div class="container">
    <div class="navbar">
        <div class="nav-item logo">
            <a href="./home">Logo</a>
        </div>
        <div class="nav-item">
            <a href="./projects">Projects</a>
        </div>
        <div class="nav-item">
            <a href="./contact">Contact</a>
        </div>
    </div>

    <main>
        <?php if (isset($title) && $title === '404'): ?>
            <h1><?= strtolower($title) ?> page not found!</h1>
            <a href="./home">Return to the home page</a>
        <?php else: ?>
            <h1>Dit is de <?= isset($title) ? strtolower($title) : 'home' ?> page</h1>
        <?php endif; ?>
        <br>

        <?php if (isset($title) && $title !== '404'): ?>
            <div class="toggle-slider-theme">
                <input type="checkbox" id="theme-toggle" class="theme-toggle" <?= $themeState ?> >
                <label for="theme-toggle">
                    <span class="thumb"></span>
                </label>
            </div>
        <?php endif; ?>
    </main>
</div>
</body>
</html>
