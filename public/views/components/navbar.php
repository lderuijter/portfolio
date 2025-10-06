<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= isset($title) ? $title : 'Portfolio' ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/script.js" defer></script>
</head>
<body>
<h1>Dit is de <?= isset($title) ? strtolower($title) : 'home' ?> page</h1>
    <nav>
        <a href="./home">Home</a> |
        <a href="./projects">Projects</a> |
        <a href="./contact">Contact</a> |
    </nav>
    <br>
    <button onclick="toggleTheme()">Toggle light theme</button>
</body>
</html>
