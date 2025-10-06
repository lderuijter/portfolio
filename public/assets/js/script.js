function toggleTheme() {
    const isLight = document.body.classList.toggle('light');
    document.querySelector('.themeInput').value = isLight ? 'light' : 'dark';
    document.querySelector('.themeForm').submit();
}
