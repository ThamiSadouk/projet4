<?php $title = SITENAME; ?>

<?php ob_start(); ?>

    <a href="<?= URLROOT; ?>/posts" class="btn btn-light"><i class="fas fa-backward"></i> Back</a>
    <div class="card card-body bg-light my-5">
        <?php flash('register_success'); ?>
        <h2>Ajouté un billet</h2>
        <p>Ecrivez un nouveau billet à l'aide du formulaire</p>
        <form action="<?= URLROOT; ?>/postsController/add" method="post">
            <div class="form-group">
                <label for="title">Titre: <sup>*</sup></label>
                <input type="text" id="title" name="title" class="form-control form-control-lg <?= (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>" value="<?= $data['title']; ?>">
                <span class="invalid-feedback"><?= $data['title_err']; ?></span>
            </div>
            <div class="form-group">
                <label for="content">Contenu: <sup>*</sup></label>
                <span class="invalid-feedback"><?= $data['content_err']; ?></span>
                <textarea class= "tinymce" id="content" name="content" class="form-control form-control-lg <?= (!empty($data['content_err'])) ? 'is-invalid' : ''; ?>"><?= $data['content']; ?></textarea>
            </div>
            <input type="submit" class="btn btn-success" value="Publier">
        </form>
    </div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>