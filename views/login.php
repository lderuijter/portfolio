<?php
require_once BASE_PATH . '/autoload.php';

use Controller\AuthController;

$auth = AuthController::getInstance();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;
    switch ($action) {
        case 'login':
            $auth->login();
            break;
        case 'logout':
            $auth->logout();
            break;
        default:
            // onbekende actie handelen
            http_response_code(400);
            echo "Invalid or missing action.";
            break;
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
