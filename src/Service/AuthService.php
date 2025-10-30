<?php

namespace Service;

class AuthService {
    // verifieer de ingevoerde wachtwoord met de stored hash door password_verify te gebruiken
    public static function verify_password($inputPassword): bool
    {
        require_once BASE_PATH . '/config.php';
        $storedHash = getenv('ADMIN_PASSWORD');
        if (!$storedHash) return false;
        return password_verify($inputPassword, $storedHash);
    }
}
