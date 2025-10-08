<?php
// initialiseer de staat van het thema, default dark
$themeState = '';
// check of het thema geset is in de sessie
if (isset($_SESSION['theme'])) {
    // check of het thema in de sessie light is, als dat zo is dan is de checkbox gecheckt, anders niet
    $themeState = $_SESSION['theme'] === 'light' ? 'checked' : '';
}
?>

<div class="toggle-slider-theme">
    <input type="checkbox" id="theme-toggle" class="theme-toggle" <?= $themeState ?> >
    <label for="theme-toggle">
        <span class="thumb"></span>
    </label>
</div>
