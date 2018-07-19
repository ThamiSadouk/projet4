<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= URLROOT; ?>/css/style.css">

    <!-- Custom styles for this template -->
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
    <link href="<?= URLROOT; ?>/css/custom.css" rel="stylesheet">

    <title><?= $title ?></title>
</head>

<body>
<!--
NAVIGATION MENU
-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
    <div class="container">
        <?php if(isset($_SESSION['user_id'])) : ?>
            <a class="navbar-brand" href="<?= URLROOT; ?>">Administration</a>
        <?php else : ?>
            <a class="navbar-brand" href="<?= URLROOT; ?>"><?= SITENAME; ?></a>
        <?php endif; ?>


        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <?php if(isLoggedIn()) : ?>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= URLROOT; ?>/postsController/add"><i class="fas fa-pencil-alt fa-lg"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= URLROOT; ?>/dashboardController/dashboard"><i class="fas fa-cog fa-lg"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= URLROOT; ?>/usersController/register"><i class="fas fa-user fa-lg"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= URLROOT; ?>/usersController/logout">Déconnexion</a>
                    </li>
                </ul>
            <?php else : ?>
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= URLROOT; ?>">Accueil</a>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!--
 INSERTION DU CONTENU
 -->
<main role="main" class="container">
    <?= $content ?>
</main>

<footer class="blog-footer">
    <p>© 2018 | Projet 4 | Thami Sadouk</p>
</footer>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

<script type="text/javascript" src="<?= URLROOT; ?>/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="<?= URLROOT; ?>/js/tinymce/jquery.tinymce.min.js"></script>
<script type="text/javascript" src="<?= URLROOT; ?>/js/tinymce/initTinymce.js"></script>
</body>
</html>