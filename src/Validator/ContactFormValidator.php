<?php

namespace Validator;

use Core\SingletonTrait;

class ContactFormValidator
{
    // Zorgt ervoor dat er maar één instantie van deze klasse bestaat
    use SingletonTrait;

    // Velden die verplicht zijn in het contactformulier
    private array $requiredFields = [
        'email' => 'Email adres is verplicht!',
        'name' => 'Naam is verplicht!',
        'phoneNumber' => 'Telefoonnummer is verplicht!',
        'message' => 'Bericht is verplicht!',
    ];

    public function __construct()
    {
        // Start de sessie als deze nog niet gestart is (nodig voor throttling)
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Valideert het formulier en vult de $errors array met eventuele fouten.
     *
     * @param array $formData  De ingevulde formuliervelden ($_POST)
     * @param array &$errors   Array waarin foutmeldingen worden opgeslagen
     */
    public function validateForm(array $formData, array &$errors): void
    {
        // Alleen valideren als het formulier met POST is verzonden
        if (!$this->isPostRequest()) {
            return;
        }

        // Beperk het verzenden van het formulier tot 1 keer per uur
        $cooldown = 3600; // 1 uur = 3600 seconden
        $lastSubmit = $_SESSION['last_form_submit'] ?? 0;
        $now = time();

        // Controleer of de gebruiker te snel opnieuw probeert te verzenden
        if ($now - $lastSubmit < $cooldown) {
            $remaining = ceil(($cooldown - ($now - $lastSubmit)) / 60);
            $errors[] = "Je kunt slechts één bericht per uur verzenden. Probeer het over {$remaining} minuten opnieuw.";
            return;
        }

        // Controleer of alle verplichte velden ingevuld zijn
        foreach ($this->requiredFields as $field => $errorMessage) {
            if (empty($formData[$field])) {
                $errors[] = $errorMessage;
            }
        }

        // Als er geen fouten zijn, sla het tijdstip van verzenden op in de sessie
        if (empty($errors)) {
            $_SESSION['last_form_submit'] = $now;
        }
    }

    /**
     * Controleert of de huidige request een POST-request is.
     *
     * @return bool True als het een POST-request is, anders false
     */
    private function isPostRequest(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
}
