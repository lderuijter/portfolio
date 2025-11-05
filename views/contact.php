<?php

use Validator\ContactFormValidator;

$errors = [];
$contactFormValidator = ContactFormValidator::getInstance();
$contactFormValidator->validateForm($_POST, $errors);
$success = empty($errors);
?>

<h1>Contact</h1>

<div class="main-contact-form-container">
    <form id="contact-form" class="form-element contact-page" method="post">
        <div class="inputs-container contact-page">
            <?php if (!empty($errors)): ?>
                <div class="errors contact-page">
                    <?php foreach ($errors as $error): ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <label class="label-container">
            <span class="icon-container">
                <i class="fa-regular fa-envelope"></i>
            </span>
                <input class="email-input" type="email" name="email" placeholder="Email" required>
            </label>

            <label class="label-container">
            <span class="icon-container">
                <i class="fa-solid fa-signature"></i>
            </span>
                <input class="name-input" type="text" name="name" placeholder="Naam" required>
            </label>

            <label class="label-container">
            <span class="icon-container">
                <i class="fa-solid fa-phone"></i>
            </span>
                <input class="phone-number-input" type="number" name="phoneNumber" placeholder="Telefoonnummer"
                       required>
            </label>

            <label class="label-container">
            <span class="icon-container">
                <i class="fa-regular fa-message"></i>
            </span>
                <textarea class="message-input" name="message" placeholder="Bericht" required></textarea>
            </label>

            <button class="create-button contact-page" type="submit">Verzenden</button>
        </div>
    </form>
</div>

<!-- EmailJS script -->
<script src="https://cdn.jsdelivr.net/npm/emailjs-com@3/dist/email.min.js"></script>

<?php if ($success && $_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <script>
        // Initialiseren van EmailJS
        emailjs.init('qAY-ygZ_W0tSdtu_X');
        const formData = {
            email: "<?= htmlspecialchars($_POST['email']) ?>",
            name: "<?= htmlspecialchars($_POST['name']) ?>",
            phoneNumber: "<?= htmlspecialchars($_POST['phoneNumber']) ?>",
            message: "<?= htmlspecialchars($_POST['message']) ?>"
        };
        emailjs.send('service_ojbbukn', 'template_ol5wxtq', formData)
            .then(() => {
                alert('Bericht succesvol verzonden!')
            })
            .catch(err => {
                console.error(err)
                alert('Er is een fout opgetreden. Het bericht is niet verzonden!')
            });
    </script>
<?php endif; ?>
