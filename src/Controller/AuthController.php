<?php

namespace Controller;

use Core\SingletonTrait;
use Service\AuthService;

class AuthController
{
    use SingletonTrait;
    // functie die het ingevoerde wachtwoord ophaalt en dit naar de verify_password functie stuurt
    public function login(): void
    {
        $password = $_POST['password'] ?? '';

        if (!empty($password) && AuthService::verify_password($password)) {
            $_SESSION['logged_in'] = true;
            header("Location: projects");
        } else {
            $_SESSION['logged_in'] = false;
            header("Location: login?error=1");
        }
    }

    // functie om te controleren of de gebruiker is ingelogd
    public function isLoggedIn()
    {
        return $_SESSION['logged_in'] ?? false;
    }

    // functie om de gebruiker uit te loggen
    public function logout(): void
    {
        $_SESSION['logged_in'] = false;
        header("Location: login");
    }

}
