<?php
$themeState = '';
if (isset($_SESSION['theme'])) {
    $themeState = $_SESSION['theme'] === 'light' ? 'checked' : '';
}
?>

<?php if (isset($title) && $title !== '404'): ?>
    <div class="toggle-slider-theme">
        <input type="checkbox" id="theme-toggle" class="theme-toggle" <?= $themeState ?> >
        <label for="theme-toggle">
            <span class="thumb"></span>
        </label>
    </div>
<?php endif; ?>