<?php
if (isset($_GET['theme'])) {
    $_SESSION['theme'] = $_GET['theme'];
}
$theme = isset($_SESSION['theme']) ? $_SESSION['theme'] : 'dark';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= isset($title) ? $title : 'Portfolio' ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/script.js" defer></script>
</head>
<body class="<?= $theme === 'light' ? 'light' : 'dark' ?>">
    <nav>
        <a href="./home">Home</a> |
        <a href="./projects">Projects</a> |
        <a href="./contact">Contact</a> |
    </nav>

    <main>
        <?php if(isset($title) && $title === '404'): ?>
        <h1><?= strtolower($title) ?> page not found!</h1>
        <a href="./home">Return to the home page</a>
        <?php else: ?>
        <h1>Dit is de <?= isset($title) ? strtolower($title) : 'home' ?> page</h1>
        <?php endif; ?>
        <br>

        <?php if(isset($title) && $title !== '404'): ?>
        <form class="themeForm" method="GET">
            <input type="hidden" name="theme" class="themeInput">
        </form>
        <button onclick="toggleTheme()">Toggle theme</button>
        <?php endif; ?>
    </main>

</body>
</html>
