<?php $title = $data['post']->getTitle(); ?>

<?php ob_start(); ?>

<a href="<?= URLROOT; ?>" class="btn btn-light mt-4"><i class="fas fa-backward"></i> Retour</a>

<div class="blog-post pt-3">
    <h2 class="blog-post-title"><?= $data['post']->getTitle(); ?></h2>
    <p class="blog-post-meta"><?= $data['post']->getCreationDateFr(); ?></p>
    <p><?= $data['post']->getContent(); ?><br></p>
</div>

<div class="comments">
    <h3>Commentaires</h3>
    <form action="<?= URLROOT; ?>/PagesController/showPost/<?= $data['post']->getId(); ?>" method="post">
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
        <p><strong><?= $comment->getAuthor();  ?></strong> le <?= $comment->getCommentDateFr(); ?></p>
        <p><?= nl2br($comment->getComment()); ?></p>
    <?php endforeach; ?>

    <?php $content = ob_get_clean(); ?>

    <?php require('template.php'); ?>
