<?php

use \App\Libraries\BaseController;

class UsersController extends BaseController
{
    public function __construct()
    {
        // charge UserManager
        $this->userModel = $this->loadModel('UserManager');
    }

    // s'occupe de charger le formulaire quand on se dirige dans la page register
    // submit the form quand on fait une requête post
    public function register()
    {
        // check for POST : si la méthode de requête POST est utilisé
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data : récupère les valeurs POST   et supprime les balises et caractères spéciaux qui peuvent être insérés
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            // Init data
            $data = [
                'name' => trim($_POST['name']), // trim permet de supprimer les espaces en début et fin de chaîne
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_error' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            // Valider email
            if(empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } else {
                // check email
                if($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'Email is already taken';
                }
            }

            // Valider nom
            if(empty($data['name'])) {
                $data['name_err'] = 'Please enter name';
            }

            // Valider mp
            if(empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            } elseif(strlen($data['password']) < 6) {
                $data['password_err'] = 'Le mot de passe doit faire au moins 6 charactères';
            }

            // Valider Confirm password
            if(empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please enter confirm password';
            } elseif($data['password'] != $data['confirm_password']) {
                $data['confirm_password_err'] = 'Les mots de passe ne correspondent pas';
            }

            // vérifie si il n'y a pas d'erreurs
            if(empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                // valider

                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // inscription utilisateur
                if($this->userModel->register($data)) {
                    flash('register_success', 'You are registered and you can log in');
                    header('location: ' . URLROOT . '/login');

                } else {
                    die('something went wrong');
                }
            } else {
                // charge view errors
                $this->loadView('register', $data);
            }
        } else {
            // init data : on place les données de l'utilisateur dans un tableau en cas d'erreur de saisie, les données précédentes sont renvoyées
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_error' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            //load view
            $this->loadView('register', $data);
        }
    }

    public function login()
    {
        // init data : on place les données de l'utilisateur dans un tableau en cas d'erreur de saisie, les données précédentes sont renvoyées
        $data = [
            'email' => '',
            'password' => '',
            'email_err' => '',
            'password_err' => '',
        ];

        //load view
        $this->loadView('login', $data);
    }
}