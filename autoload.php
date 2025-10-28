<?php
spl_autoload_register(function ($class) {
    // Convert namespace separators to directory separators
    $path = BASE_PATH . '/src/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});