<?php $title = SITENAME; ?>

<?php ob_start(); ?>

    <?php if(isset($_SESSION['user_id'])) : ?>
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
        <h4><?= htmlspecialchars($post->title) ?></h4>
        <div class="bg-light p-2 mb-3">
            écrit par Thami le <?= $post->creation_date_fr ?>
        </div>

        <p class="card-text"><?= nl2br(htmlspecialchars($post->content)) ?>        </p>
        <a href="<?= URLROOT; ?>/pagesController/showPost/<?= htmlspecialchars($post->id) ?>" class="btn btn-dark">En savoir plus</a>
    </div>
<?php endforeach; ?>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>