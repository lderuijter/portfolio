<div class="navbar">
    <button class="burger">
        <span></span>
        <span></span>
        <span></span>
    </button>

    <div class="nav-links">
        <a class="<?= (PAGE === 'home') ? 'active' : '' ?>" href="<?= BASE_URL ?>home">Home</a>
        <a class="<?= (PAGE === 'projects') ? 'active' : '' ?>" href="<?= BASE_URL ?>projects">Projects</a>
        <a class="<?= (PAGE === 'contact') ? 'active' : '' ?>" href="<?= BASE_URL ?>contact">Contact</a>

        <!-- Als je bent ingelogd moet hier logout komen te staan -->
        <a class="<?= (PAGE === 'login') ? 'active' : '' ?>" href="<?= BASE_URL ?>login">Login</a>

        <?php if (AUTH->isLoggedIn()) : ?>
            <a class="<?= (PAGE === 'createProject') ? 'active' : '' ?>" href="<?= BASE_URL ?>createProject">Create</a>
        <?php endif; ?>

    </div>
</div>
