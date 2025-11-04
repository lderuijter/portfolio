<?php AUTH->handleRequest($_POST); ?>

<?php if (!AUTH->isLoggedIn()): ?>
    <h1>Login</h1>
<?php else: ?>
    <h1>Logout</h1>
<?php endif; ?>

<div class="main-login-container">
    <?php if (!AUTH->isLoggedIn()): ?>
        <form method="post">
            <div class="login-logout-container">
                <?php if (isset($_GET['error'])): ?>
                    <div class="incorrect-password">
                        <p>Incorrect password!</p>
                    </div>
                <?php endif; ?>
                <label>
                    <input class="password-input" type="password" name="password" placeholder="Enter your password"
                           required>
                    <button class="toggle-password" type="button">
                        <i class="fa fa-eye"></i>
                    </button>
                </label>
                <button class="login-button" name="action" type="submit" value="login">
                    Login
                </button>
            </div>
        </form>
    <?php else: ?>
        <form method="post">
            <div class="login-logout-container">
                <button class="logout-button" name="action" type="submit" value="logout">
                    Logout
                </button>
            </div>
        </form>
    <?php endif; ?>
</div>
