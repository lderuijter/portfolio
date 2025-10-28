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

<h1>Login / Logout</h1>

<?php if (isset($_GET['error'])): ?>
<div class="incorrect-password">
    <p>Incorrect password</p>
</div>
<?php endif; ?>

<?php if (!$auth->isLoggedIn()): ?>
<form method="post">
    <label for="password">
        <input id="password" type="password" name="password" placeholder="Password">
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
