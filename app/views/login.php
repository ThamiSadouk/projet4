<?php $title = SITENAME; ?>

<?php ob_start(); ?>

    <div class="row">
        <div class="col-md-6 mx-auto my-5">
            <div class="card card-body bg-light my-5">
                <?php flash('register_success'); ?>
                <h2>Connection</h2>
                <p>Connectez-vous à votre compte.</p>
                <form action="<?= URLROOT; ?>/usersController/login" method="post">
                    <div class="form-group">
                        <label for="email">Email: <sup>*</sup></label>
                        <input type="email" name="email" class="form-control form-control-lg <?= (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?= $data['email']; ?>">
                        <span class="invalid-feedback"><?= $data['email_err']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe: <sup>*</sup></label>
                        <input type="password" name="password" class="form-control form-control-lg <?= (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?= $data['password']; ?>">
                        <span class="invalid-feedback"><?= $data['password_err']; ?></span>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <input type="submit" value="Login" class="btn btn-success btn-block">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>