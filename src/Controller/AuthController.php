<?php

namespace Controller;

use Core\SingletonTrait;
use Service\AuthService;

class AuthController
{
    use SingletonTrait;

    private AuthService $authService;

    public function __construct()
    {
        // AuthService singleton ophalen
        $this->authService = AuthService::getInstance();
    }

    // functie om te controleren of de gebruiker is ingelogd
    public function isLoggedIn()
    {
        return $_SESSION['logged_in'] ?? false;
    }

    public function handleRequest(?array $formData): void
    {
        if (!$this->isPostRequest()) {
            return; // Alleen POST-requests verwerken
        }

        $action = $formData['action'] ?? null;

        match ($action) {
            'login' => $this->login(),
            'logout' => $this->logout(),
            default  => $this->badRequest('Ongeldige of ontbrekende actie.'),
        };
    }

    // functie die het ingevoerde wachtwoord ophaalt en dit naar de verify_password functie stuurt
    private function login(): void
    {
        $password = $_POST['password'] ?? '';

        if (!empty($password) && $this->authService->verify_password($password)) {
            $_SESSION['logged_in'] = true;
            $this->redirect('projects');
        } else {
            $_SESSION['logged_in'] = false;
            $this->redirect('login?error=1');
        }
    }

    // functie om de gebruiker uit te loggen
    private function logout(): void
    {
        $_SESSION['logged_in'] = false;
        header("Location: login");
    }

    // Controleert of het een POST-request is
    private function isPostRequest(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    // Stuurt door naar een andere pagina
    private function redirect(string $url): void
    {
        header("Location: $url");
    }

    // Geeft een foutmelding bij een ongeldige actie
    private function badRequest(string $message): void
    {
        http_response_code(400);
        echo $message;
    }

}
