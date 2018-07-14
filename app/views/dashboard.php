<?php $title = SITENAME; ?>

<?php ob_start(); ?>

<h2>Tableau de bord</h2>
<?php flash('post_message'); ?>

<div class="container mt-5">
    <div class="row ">
        <?php foreach ($data['tables'] as $table) : ?>
            <div class="col-md-4">
                <div class="card flex-md-row mb-4 box-shadow h-md-200">
                    <div class="card-body align-items-start">
                        <h3><?= $table[0]; ?></h3>
                        <h4><?= $table[1]; ?></h4>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</div>

<h4>Commentaires Signalés</h4>

<table class="table">
    <thead>
        <tr>
            <th scope="col">Billet</th>
            <th scope="col">Commentaire</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
       <?php foreach ($data['comments'] as $comment) : ?>
        <tr id="row_<?= $comment->id; ?>">
            <td><?= $comment->title; ?></td>
            <td><?= substr($comment->comment, 0, 100); ?>...</td>
            <td>
                <div class="d-flex">
                    <form action="<?= URLROOT; ?>/dashboardController/see/<?= $comment->id ?>" method="post">
                        <button type="submit" value="submit" class="btn btn-success btn-circle mx-1"><i class="fas fa-check fa-lg"></i></button>
                    </form>
                    <form action="<?= URLROOT; ?>/dashboardController/delete/<?= $comment->id ?>" method="post">
                        <button type="submit" value="submit" class="btn btn-circle btn-danger mx-1"><i class="fas fa-trash fa-lg"></i></button>
                    </form>
                    <a href="#comment_<?= $comment->id; ?>" role="button" class="btn btn-circle btn-info mx-1" data-toggle="modal"><i class="fas fa-ellipsis-v fa-lg"></i></a>
                </div>


                <!-- MODAL -->
                <div class="modal fade" id="comment_<?= $comment->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"><?= $comment->title; ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Commentaire posté par <strong><?= $comment->author; ?></strong><br/>Le <?= $comment->commentDateFr; ?></p>
                                <hr class="border">
                                <p><?= nl2br($comment->comment); ?></p>
                            </div>
                            <div class="modal-footer">
                                <div class="d-flex">
                                    <form action="<?= URLROOT; ?>/dashboardController/see/<?= $comment->id ?>" method="post">
                                        <button type="submit" value="submit" class="btn btn-circle btn-outline-success mx-1">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form action="<?= URLROOT; ?>/dashboardController/delete/<?= $comment->id ?>" method="post">
                                        <button type="submit" value="submit" class="btn btn-circle btn-outline-danger mx-1">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>