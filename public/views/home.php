<?php
// de base variabele wordt altijd opgehaald uit de config.php
/** @var $base */
?>

<h1 class="page-heading">Home page</h1>

<div class="about-me-container">
    <div class="lucas-image-container">
        <div class="circle-image">
            <img src="<?= $base ?>assets/images/lucas.png" alt="profile">
        </div>
    </div>
    <div class="about-me-text">
        <h2>Lucas de Ruijter</h2>
        <p>Ik heb altijd al interesse gehad in de
            ICT-sector en ik vind het leuk om te
            programmeren. Ik ben iemand die
            oplossingsgericht is ingesteld. Verder
            houd ik van uitdagend werk. Ook ben
            ik heel nauwkeurig en word ik
            omschreven als een echte doorzetter.
            Ik ben sterk gemotiveerd om
            innovatieve en functionele applicaties
            en websites te ontwikkelen met een
            leuk softwareteam. </p>
    </div>
    <div class="about-me-icons">
        <a target="_blank" href="https://github.com/lderuijter">
            <img src="https://lucasderuijter.vercel.app/public/github-icon.png" alt="github">
        </a>
        <a target="_blank" href="https://www.linkedin.com/in/lucas-de-ruijter-61211a215/">
            <img src="https://lucasderuijter.vercel.app/public/linkedin-icon.png" alt="linkedIn">
        </a>
    </div>
</div>

<h2>Projects preview</h2>

<div class="project-preview-container">
    <div class="preview-image">
        <img src="https://lucasderuijter.vercel.app/public/generate-form.png" alt="preview-project">
    </div>
    <div class="preview-image">
        <img src="<?= $base ?>assets/images/ProjectCardAdmin.png" alt="preview-project">
    </div>
    <div class="preview-button">
        <a href="<?= $base ?>projects">
            <p>View more</p>
        </a>
    </div>
</div>
