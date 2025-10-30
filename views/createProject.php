<?php
// Op de pagina van het aanmaken of bewerken van een project moet de gebruiker ingelogd zijn
if (!AUTH->isLoggedIn()) {
    header('Location: login');
}
?>

<h1>Create projects</h1>
