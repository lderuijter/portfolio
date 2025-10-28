<?php

namespace Controller;

use Service\AuthService;

class AuthController
{
    private static $instance = null;

    private function __construct() {} // private constructor
    private function __clone() {} // clone uitgeschakeld

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new AuthController();
        }
        return self::$instance;
    }

    // functie die het ingevoerde wachtwoord ophaalt en dit naar de verify_password functie stuurt
    public function login()
    {
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        if (!empty($password) && AuthService::verify_password($password)) {
            $_SESSION['logged_in'] = true;
            header("Location: projects");
        } else {
            $_SESSION['logged_in'] = false;
            header("Location: login?error=1");
        }
    }

    // functie om te controleren of de gebruiker is ingelogd
    public function isLoggedIn() {
        return isset($_SESSION['logged_in']) ? $_SESSION['logged_in'] : false;
    }

    // functie om de gebruiker uit te loggen
    public function logout() {
        session_destroy();
        header("Location: login");
    }

}
