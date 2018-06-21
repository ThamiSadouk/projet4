<?php $title = htmlspecialchars($posts['title']) ?>

<?php ob_start(); ?>

<h1>Mon super blog !</h1>
<p><a href="<?= URLROOT; ?>">Retour à la liste des billets</a></p>

<div class="news">
    <h3>
        <?= htmlspecialchars($posts['title']) ?>
        <em>le <?= htmlspecialchars($posts['creation_date_fr']) ?></em>
    </h3>
    <p>
        <?= htmlspecialchars($posts['content']) ?><br>
    </p>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
