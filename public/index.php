<?php
session_start();

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

$title = ucfirst($page);

$validPages = ['home', 'projects', 'contact'];

if (!in_array($page, $validPages)) {
    http_response_code(404);
    $page = '404';
}

include __DIR__ . "/views/$page.php";