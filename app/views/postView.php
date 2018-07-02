<?php $title = $data['post']->getTitle(); ?>

<?php ob_start(); ?>

<a href="<?= URLROOT; ?>" class="btn btn-light mt-4"><i class="fas fa-backward"></i> Retour</a>

<div class="blog-post">
    <h2 class="blog-post-title"><?= $data['post']->getTitle(); ?></h2>
    <p class="blog-post-meta"><?= $data['post']->getCreationDateFr(); ?></p>
    <p><?= $data['post']->getContent(); ?><br></p>
</div>

<?php if(isLoggedIn() && $data['post']->getUserId() == $_SESSION['user_id']) : ?>
    <hr>
    <div class="row justify-content-between">
        <a href="<?= URLROOT; ?>/postsController/edit/<?= $data['post']->getId(); ?>" class="btn btn-dark">Modifier</a>
        <form action="<?= URLROOT; ?>/postsController/delete/<?= $data['post']->getId(); ?>" method="post">
            <input type="submit" value="Supprimer" class="btn btn-danger">
        </form>
    </div>
<?php endif; ?>

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
    <?php if($comment->getSignalement()) : ?>
        <h4>Ce commentaire est signalé</h4>
     <?php else: ?>
        <form action="" method="post">
            <input type="submit" value="signaler">
            <input type="hidden" value="<?= $comment->getId(); ?>" name="comment_signalement">
        </form>
    <?php endif; ?>
    <?php endforeach; ?>

    <?php $content = ob_get_clean(); ?>



    <?php require('template.php'); ?>
