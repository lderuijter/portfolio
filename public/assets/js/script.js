const themeToggle = document.querySelector('.theme-toggle');

themeToggle.addEventListener('change', () => {
    const theme = themeToggle.checked ? 'light' : 'dark';

    // Update body class
    document.body.classList.toggle('light', theme === 'light');
    document.body.classList.toggle('dark', theme === 'dark');

    // Send theme to PHP session
    fetch(window.location.href, {
        method: 'POST',
        body: new URLSearchParams({theme}),
        credentials: 'same-origin'
    }).then(() => location.reload())
        .catch(err => console.error(err));
});
