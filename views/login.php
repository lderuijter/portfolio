<?php AUTH->handleRequest($_POST); ?>

<?php if (!AUTH->isLoggedIn()): ?>
    <h1>Login</h1>
<?php else: ?>
    <h1>Logout</h1>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <div class="incorrect-password">
        <p>Incorrect password!</p>
    </div>
<?php endif; ?>
<?php if (!AUTH->isLoggedIn()): ?>
    <form method="post">
        <label for="password">
            <input id="password" type="password" name="password" placeholder="Password" required>
        </label>
        <button name="action" type="submit" value="login">
            Login
        </button>
    </form>
<?php else: ?>
    <form method="post">
        <button name="action" type="submit" value="logout">
            Logout
        </button>
    </form>
<?php endif; ?>
