<?php $title = SITENAME; ?>

<?php ob_start(); ?>
    <?php flash('post_message'); ?>
    <?php if(isLoggedIn()) : ?>
        <div class="col-md-6">
            <a href="<?= URLROOT; ?>/postsController/add" class="btn btn-primary pull-right">
                <i class="fas fa-pencil-alt"></i> Ajouté billet
            </a>
        </div>
        <?php else : ?>
        <div class="jumbotron jumbotron-fluid text-center">
            <div class="container">
                <h1 class="display-3">Billet simple pour l'Alaska</h1>
                <p class="lead">Publication par épisode en ligne du nouveau roman de l'écrivain et acteur Jean Forteroche.</p>
            </div>
        </div>
        <?php endif; ?>


<?php foreach($data['posts'] as $post) : ?>
    <div class="card card-body mt-3 mb-3">
        <h4><?= $post->getTitle(); ?></h4>
        <div class="bg-light p-2 mb-3">
            écrit par Thami le <?= $post->getcreationDateFr(); ?>
        </div>

        <p class="card-text"><?= $post->getContent(); ?> </p>
        <a href="<?= URLROOT; ?>/pagesController/showPost/<?= $post->getId();  ?>" class="btn btn-dark">En savoir plus</a>
    </div>
<?php endforeach; ?>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>