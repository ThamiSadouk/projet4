<?php
use App\Libraries\BaseController;

class PostsController extends BaseController
{
    public function __construct()
    {
        // Vérifie si l'id de session du user existe. Si retourne vrai, cela veut dire qu'on est connecté sinon on redirige.
        $this->postModel = $this->loadModel('PostManager');
        $this->userModel = $this->loadModel('UserManager');
    }


    public function add()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize post array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'title' => trim($_POST['title']),
                'user_id' => $_SESSION['user_id'],
                'content' => trim($_POST['content']),
                'title_err' => '',
                'content_err' => ''
            ];

            // vérifie si il n'y a pas d'erreur
            if(empty($data['title_err']) && empty($data['content_err'])) {
                // valider
                if($this->postModel->addPost($data)) {
                    flash('post_message', 'Billet ajouté');
                    header('Location: ' . URLROOT);

                } else {
                    die('une erreur est survenue');
                }
            } else {
                // affiche les messages d'erreurs
                $this->loadView('addPost', $data);
            }
        }else {
            $data = [
                'title' => '',
                'content' => ''
            ];

            $this->loadView('addPost', $data);
        }
    }

    public function edit()
    {

    }

    public function delete()
    {

    }



}