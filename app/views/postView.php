<?php $title = htmlspecialchars($data['post']->title) ?>

<?php ob_start(); ?>

<h1>Mon super blog !</h1>
<p><a href="<?= URLROOT; ?>">Retour à la liste des billets</a></p>

<div class="news">
    <h3>
        <?= htmlspecialchars($data['post']->title) ?>
        <em>le <?= htmlspecialchars($data['post']->creation_date_fr) ?></em>
    </h3>
    <p>
        <?= htmlspecialchars($data['post']->content) ?><br>
    </p>
</div>
<div class="comments">
    <h3>Commentaires</h3>
    <?php foreach ($data['comments'] as $comment) : ?>

        <p><strong><?= htmlspecialchars($comment->author) ?></strong> le <?= $comment->comment_date_fr ?></p>
        <p><?= nl2br(htmlspecialchars($comment->comment)) ?></p>
    <?php endforeach; ?>

    <?php $content = ob_get_clean(); ?>

    <?php require('template.php'); ?>

</div>

