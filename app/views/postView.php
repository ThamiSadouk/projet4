<?php $title = $data['post']->getTitle(); ?>

<?php ob_start(); ?>

<a href="<?= URLROOT; ?>" class="btn btn-light mt-4"><i class="fas fa-backward"></i> Retour</a>

<div class="blog-post mb-3">
    <h2 class="blog-post-title"><?= $data['post']->getTitle(); ?></h2>
    <p class="blog-post-meta"><?= $data['post']->getCreationDateFr(); ?></p>
    <p><?= $data['post']->getContent(); ?><br></p>
</div>
<hr>

<?php if(isLoggedIn() && $data['post']->getUserId() == $_SESSION['user_id']) : ?>
    <div class="row justify-content-between">
        <a href="<?= URLROOT; ?>/postsController/edit/<?= $data['post']->getId(); ?>" class="btn btn-dark">Modifier</a>
        <form action="<?= URLROOT; ?>/postsController/delete/<?= $data['post']->getId(); ?>" method="post">
            <input type="submit" value="Supprimer" class="btn btn-danger">
        </form>
    </div>
<?php endif; ?>

<div class="comments">
    <h3>Rédiger un commentaire</h3>

    <form action="<?= URLROOT; ?>/postsController/showPost/<?= $data['post']->getId(); ?>" method="post">
        <div class="form-group row">
            <label for="author" class="sr-only">Auteur <sup>*</sup></label>
            <input id="author" type="text" name="author" class="col-sm-4 form-control <?= (!empty($dataForm['author_err'])) ? 'is-invalid' : ''; ?>" value="<?= $dataForm['author']; ?>" placeholder="Auteur">
            <span class="invalid-feedback"><?= $dataForm['author_err']; ?></span>
        </div>
        <div class="form-group row">
            <label for="comment" class="sr-only">Ecrire un commentaire <sup>*</sup></label>
            <textarea id="comment" name="comment" rows="5" placeholder="Ecrire un commentaire" class="col-sm-4 form-control <?= (!empty($dataForm['comment_err'])) ? 'is-invalid' : ''; ?>"><?= $dataForm['comment']; ?></textarea>
            <span class="invalid-feedback"><?= $dataForm['comment_err']; ?></span>
        </div>
        <input type="submit" class="btn btn-success" value="publier">
    </form>

    <h3>Commentaires</h3>
    <?php foreach ($data['comments'] as $comment) : ?>
        <p><strong><?= $comment->getAuthor();  ?></strong> le <?= $comment->getCommentDateFr(); ?></p>
        <p><?= $comment->getComment(); ?></p>
    <?php if($comment->getSignalement()) : ?>
        <h4>Ce commentaire est signalé</h4>
     <?php else: ?>
        <form action="<?= URLROOT; ?>/postsController/showPost/<?= $data['post']->getId(); ?>" method="post">
            <input type="submit" value="signaler">
            <input type="hidden" value="<?= $comment->getId(); ?>" name="comment_signalement">
        </form>
    <?php endif; ?>
    <?php endforeach; ?>

    <?php $content = ob_get_clean(); ?>



    <?php require('template.php'); ?>
