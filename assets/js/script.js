// dit zorgt ervoor dat je niet opnieuw het formulier verstuurd bij elke refresh
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}

// Haal de theme toggle op door de class van de checkbox element aan te roepen
const themeToggle = document.querySelector('.theme-toggle');

// Luisteren voor changes in de checkbox
themeToggle.addEventListener('change', () => {
    // Als de checkbox is aangevinkt, is de theme light, anders is de theme dark
    const theme = themeToggle.checked ? 'light' : 'dark';

    // Toggle de theme voor light of dark en maak het een eenzijdige change door de boolean als tweede parameter te geven
    document.body.classList.toggle('light', theme === 'light');
    document.body.classList.toggle('dark', theme === 'dark');

    // Verstuur een POST request naar de server met de nieuwe theme als parameter
    fetch(window.location.href, {
        method: 'POST',
        body: new URLSearchParams({theme}),
        credentials: 'same-origin'
        // Als er een fout is, log het naar de console
    }).catch(err => console.error(err));
});

// Haal de burger button op via de class
const burger = document.querySelector('.burger');
// Haal de nav links div op via de class
const navLinks = document.querySelector('.nav-links');

// Luisteren voor clicks op de burger button
burger.addEventListener('click', () => {
    // Maak de burger button active of niet active
    burger.classList.toggle('active');
    // Laat de navigatie links zien of verbergen
    navLinks.classList.toggle('show');
});

// Luisteren voor clicks op de toggle button wanneer de pagina is geladen anders is de button niet beschikbaar
document.addEventListener('DOMContentLoaded', () => {
    // Haal de description text container op via de class
    const descriptionTextContainer = document.querySelectorAll('.project-description');

    // Haal de benodigde elementen op via de class
    const modal = document.querySelector('.full-description-modal');
    const modalOverlay = document.querySelector('.modal-overlay');
    const hideModal = document.querySelector('.hide-modal');
    const projectDescription = document.querySelector('.full-description');

    // Als een element niet is gevonden, return
    if (!modal || !hideModal || !modalOverlay || !projectDescription) {
        return;
    }

    // for each nodig omdat er meerdere projecten zijn
    descriptionTextContainer.forEach(container => {
        // Haal de toggle text button op via de class
        const toggleTextButton = container.querySelector('.toggle-text');
        // Haal text content op van het huidige project via de dataset
        const textContent = container.dataset.description;

        // Als een element niet is gevonden, return
        if (!toggleTextButton || !textContent) {
            return;
        }

        // Luisteren voor clicks op de toggle button
        toggleTextButton.addEventListener('click', () => {
            // Niet meer scrollen
            document.body.style.overflow = "hidden";
            // Laat de modal en modal overlay zien
            modalOverlay.style.display = 'block';
            modal.style.display = 'flex';
            // Zorgen voor text van het huidige project
            projectDescription.innerHTML = textContent;
        });

        // Luisteren voor clicks op de hide modal button
        hideModal.addEventListener('click', () => {
            // Wel weer scrollen
            document.body.style.overflow = "";
            // Verberg de modal en modal overlay
            modalOverlay.style.display = 'none';
            modal.style.display = 'none';
        });
    })
})

// Haal de toggle button op via de class
const toggleButton = document.querySelector('.toggle-password');

if (toggleButton) {

    // Haal de password input op via de class
    const passwordInput = document.querySelector('.password-input');
    // Luisteren voor clicks op de toggle button
    toggleButton.addEventListener('click', () => {

        // isPassword ophalen door middel van boolean operator
        const isPassword = passwordInput.type === 'password';
        // Verander het type van de passwordInput naar text of password
        passwordInput.type = isPassword ? 'text' : 'password';
        // Haal de icon van de toggle button op via de class
        const icon = document.querySelector('.toggle-password i');

        /* Verander de icon van de toggle button naar
        eye (je kan het wachtwoord zien)
        of eye slash (je kan het wachtwoord niet zien) */
        icon.classList.toggle('fa-eye', !isPassword);
        icon.classList.toggle('fa-eye-slash', isPassword);
    });
}
