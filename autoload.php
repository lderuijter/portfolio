<?php
spl_autoload_register(function ($class) {
    // Van namespace separators naar directory separators omzetten
    $path = BASE_PATH . '/src/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($path)) {
        // Benodigde class ophalen
        require_once $path;
    }
});