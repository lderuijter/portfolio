<?php
require_once BASE_PATH . '/autoload.php';

use Controller\AuthController;

$auth = AuthController::getInstance();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        $auth->login();
    }
    if (isset($_POST['logout'])) {
        $auth->logout();
    }
}
?>

<?php if (!$auth->isLoggedIn()): ?>
    <h1>Login</h1>
<?php else: ?>
    <h1>Logout</h1>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <div class="incorrect-password">
        <p>Incorrect password</p>
    </div>
<?php endif; ?>
<?php if (!$auth->isLoggedIn()): ?>
    <form method="post">
        <label for="password">
            <input id="password" type="password" name="password" placeholder="Password" required>
        </label>
        <button name="login" type="submit" value="Login">
            Login
        </button>
    </form>
<?php else: ?>
    <form method="post">
        <button name="logout" type="submit" value="Logout">
            Logout
        </button>
    </form>
<?php endif; ?>
