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
        // Doe een reload zodat het thema goed wordt opgeslagen in de sessie
    }).then(() => location.reload())
        // Als er een fout is, log het naar de console
        .catch(err => console.error(err));
});
