<?php
spl_autoload_register(function ($class) {
    // Van namespace separators naar directory separators omzetten
    $path = BASE_PATH . '/src/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($path)) {
        // Benodigde class ophalen
        require_once $path;
    }
});

function load_css_folder($path): void
{
    $fullPath = BASE_PATH . "/$path";
    $baseUrl = BASE_URL . $path;

    // scan folder voor .css bestanden
    foreach (glob("$fullPath/*.css") as $file) {
        $fileName = basename($file);
        echo '<link rel="stylesheet" href="' . $baseUrl . '/' . $fileName . '">' . PHP_EOL;
    }
}
