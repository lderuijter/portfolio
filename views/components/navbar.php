<?php
// zorg ervoor dat de huidige pagina bekend is in de variabele page
$page = $_GET['page'] ?? 'home';
?>
<div class="navbar">
    <button class="burger">
        <span></span>
        <span></span>
        <span></span>
    </button>

    <div class="nav-links">
        <a class="<?= ($page === 'home') ? 'active' : '' ?>" href="<?= BASE_URL ?>home">Home</a>
        <a class="<?= ($page === 'projects') ? 'active' : '' ?>" href="<?= BASE_URL ?>projects">Projects</a>
        <a class="<?= ($page === 'contact') ? 'active' : '' ?>" href="<?= BASE_URL ?>contact">Contact</a>

        <!-- Als je bent ingelogd moet hier logout komen te staan -->
        <a class="<?= ($page === 'login') ? 'active' : '' ?>" href="<?= BASE_URL ?>login">Login</a>

        <!-- Laat de create link alleen maar zien als de gebruiker is ingelogd -->
        <a class="<?= ($page === 'createProject') ? 'active' : '' ?>" href="<?= BASE_URL ?>createProject">Create</a>

    </div>
</div>
