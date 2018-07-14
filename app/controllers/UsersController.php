<?php

use \App\Libraries\BaseController;

class UsersController extends BaseController
{
    public function __construct()
    {
        // charge UserManager
        $this->userModel = $this->loadModel('UserManager');
    }

    // charge le formulaire quand on se dirige dans la page register
    // submit the form quand on fait une requête post
    public function register()
    {
        // check for POST : si la méthode de requête POST est utilisé
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data : récupère les valeurs POST et supprime les balises et caractères spéciaux qui peuvent être insérés
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
                $data['email_err'] = 'Veuillez entrer un email';
            } else {
                // vérifie si l'email existe déjà
                if($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'L\'email est déjà utilisé';
                }
            }

            // Valider nom
            if(empty($data['name'])) {
                $data['name_err'] = 'Veuillez entrer un nom d\'utilisateur';
            } else {
                // vérifie si le nom existe déjà
                if($this->userModel->findUserByName($data['name'])) {
                    $data['name_err'] = 'Le pseudo déjà utilisé';
                }
            }

            // Valider mp
            if(empty($data['password'])) {
                $data['password_err'] = 'Veuillez entrer un mot de passe';
            } elseif(strlen($data['password']) < 6) {
                $data['password_err'] = 'Le mot de passe doit faire au moins 6 charactères';
            }

            // Valider Confirm password
            if(empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Veuillez confirmer le mot de passe';
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
                    flash('register_success', 'Vous êtes inscrit !  Vous pouvez maintenant vous connecter');
                    header('location: ' . URLROOT . '/usersController/login');

                } else {
                    die('une erreur est survenue');
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

    public function login() {
        // check for POST : si la méthode de requête POST est utilisé
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            // Init data
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => '',
            ];

            // Valider email
            if(empty($data['email'])) {
                $data['email_err'] = 'Veuillez entrer un email';
            } elseif($this->userModel->findUserByEmail($data['email'])) { // Check for user/email
                // User found
            } else {
                // User not found
                $data['email_err'] = 'Aucun utilisateur trouvé';
            }

            // Valider mp
            if(empty($data['password'])) {
                $data['password_err'] = 'Veuillez entrer un mot de passe';
            }

            // vérifie si il n'y a pas d'erreurs
            if(empty($data['email_err']) && empty($data['password_err'])) {
                // valider
                // check et set loggedInUser
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if($loggedInUser) {
                    // créé session
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_err'] = 'mot de passe incorrect';
                    $this->loadView('login', $data);
                }
            } else {
                // charge view errors
                $this->loadView('login', $data);
            }

        } else {
            // init data : on place les données de l'utilisateur dans un tableau en cas d'erreur de saisie, les données précédentes sont renvoyées
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => '',
            ];

            //charge vue
            $this->loadView('login', $data);
        }
    }

    /*
     * Set the user datas from the db to a SESSION variable
     * $user vient de la méthode login du modele UserManager qui renvoie $row (cette variable contients les details du user)
     */
    public function createUserSession($user)
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
        header('Location: ' . URLROOT);
    }

    /*
     * unset the sessions variables
     * destroy the global variable
     * redirect to the login page
     */
    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        session_destroy();
        header('Location: ' . URLROOT);
    }
}