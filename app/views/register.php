<?php ob_start(); ?>

    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body bg-light mt-5">
                <h2>Créer un compte administrateur</h2>
                <p>Saisissez les informations demandées</p>
                <form action="<?= URLROOT; ?>/usersController/register" method="post">
                    <div class="form-group">
                        <label for="name">Nom: <sup>*</sup></label>
                        <input type="text" name="name" class="form-control form-control-lg <?= (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?= $data['name']; ?>">
                        <span class="invalid-feedback"><?= $data['name_err']; ?></span>
                    </div>
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
                    <div class="form-group">
                        <label for="confirm_password">Confirmez votre mot de passe: <sup>*</sup></label>
                        <input type="password" name="confirm_password" class="form-control form-control-lg <?= (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" value="<?= $data['confirm_password']; ?>">
                        <span class="invalid-feedback"><?= $data['confirm_password_err']; ?></span>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="submit" value="valider" class="btn btn-success btn-block">
                        </div>
                        <div class="col">
                            <a href="<?= URLROOT; ?>/usersController/login" class="btn btn-light btn-block">Vous avez un compte? Se connecter</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>