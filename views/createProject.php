<?php
require_once BASE_PATH . '/autoload.php';

use Controller\AuthController;
// controller class ophalen via de singleton methode
$auth = AuthController::getInstance();
// Op de pagina van het aanmaken of bewerken van een project moet de gebruiker ingelogd zijn
if (!$auth->isLoggedIn()) {
    header('Location: login');
}
?>

<h1>Create projects</h1>
