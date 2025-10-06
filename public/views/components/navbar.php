<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= isset($title) ? $title : 'Portfolio' ?></title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
<h1>Dit is de <?= isset($title) ? strtolower($title) : 'home' ?> page</h1>
    <nav>
        <a href="./home">Home</a> |
        <a href="./projects">Projects</a> |
        <a href="./contact">Contact</a> |
    </nav>
</body>
</html>
