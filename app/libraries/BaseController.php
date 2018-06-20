<?php

namespace App\Libraries;
/*
 * Charge les models et les views
 */
class BaseController
{
    public function loadModel($model) {
        require_once '../app/models/' . $model . '.php';

        // instatiation du model
        return new $model();
    }

    public function loadView($view, $posts) {
        // Vérifie si le fichier dans dossier views existe
        if(file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        } else {
            die('View does not exist');
        }
    }
}