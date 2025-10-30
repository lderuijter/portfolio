<?php
$page = $_GET['page'] ?? 'home';

$title = ucfirst($page);

$validPages = ['home', 'projects', 'createProject', 'contact', 'login'];

if (!in_array($page, $validPages)) {
    http_response_code(404);
    $page = '404';
}

include BASE_PATH . "/views/$page.php";

if ($page !== '404') {
    include 'views/components/themeSlider.php';
}