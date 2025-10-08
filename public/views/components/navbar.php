<?php
/** @var $base */
// zorg ervoor dat de huidige pagina bekend is in de variabele page
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>
<div class="navbar">
    <button class="burger">
        <span></span>
        <span></span>
        <span></span>
    </button>

    <div class="nav-links">
        <a class="<?= ($page === 'home') ? 'active' : '' ?>" href="<?= $base ?>home">Home</a>
        <a class="<?= ($page === 'projects') ? 'active' : '' ?>" href="<?= $base ?>projects">Projects</a>
        <a class="<?= ($page === 'contact') ? 'active' : '' ?>" href="<?= $base ?>contact">Contact</a>
    </div>
</div>
