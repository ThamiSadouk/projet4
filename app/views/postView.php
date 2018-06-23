<?php $title = htmlspecialchars($data['post']->title) ?>

<?php ob_start(); ?>

<a href="<?= URLROOT; ?>" class="btn btn-light mt-4"><i class="fas fa-backward"></i> Retour</a>

<div class="blog-post pt-3">
    <h2 class="blog-post-title"><?= htmlspecialchars($data['post']->title) ?></h2>
    <p class="blog-post-meta"><?= htmlspecialchars($data['post']->creation_date_fr) ?></p>
    <p><?= htmlspecialchars($data['post']->content) ?><br></p>
</div>

<div class="comments">
    <h3>Commentaires</h3>
    <form action="<?= URLROOT; ?>/PagesController/showPost/<?= $data['post']->id ?>" method="post">
        <div>
            <label for="author">Auteur</label><br />
            <input type="text" id="author" name="author" />
        </div>
        <div>
            <label for="comment">Commentaire</label><br />
            <textarea id="comment" name="comment"></textarea>
        </div>
        <div>
            <input type="submit" />
        </div>
    </form>

    <?php foreach ($data['comments'] as $comment) : ?>

        <p><strong><?= htmlspecialchars($comment->author) ?></strong> le <?= $comment->comment_date_fr ?></p>
        <p><?= nl2br(htmlspecialchars($comment->comment)) ?></p>
    <?php endforeach; ?>

    <?php $content = ob_get_clean(); ?>

    <?php require('template.php'); ?>
