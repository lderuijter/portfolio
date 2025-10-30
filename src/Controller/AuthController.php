<?php

namespace Controller;

use Service\AuthService;

class AuthController
{
    private static ?AuthController $instance = null;

    // functie om een enkele instantie van de AuthController te maken singleton pattern
    public static function getInstance(): ?AuthController
    {
        if (self::$instance === null) {
            self::$instance = new AuthController();
        }
        return self::$instance;
    }

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
