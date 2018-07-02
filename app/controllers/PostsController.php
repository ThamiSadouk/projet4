<?php
use App\Libraries\BaseController;

class PostsController extends BaseController
{
    public function __construct()
    {
        // Vérifie si l'id de session du user existe. Si retourne vrai, cela veut dire qu'on est connecté sinon on redirige.
        if(!isLoggedIn())
        {
            header('location: ' . URLROOT . '/usersController/login');
        }

        $this->postModel = $this->loadModel('PostManager');
        $this->userModel = $this->loadModel('UserManager');
    }


    public function add()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize post array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'user_id' => $_SESSION['user_id'],
                'title' => trim($_POST['title']),
                'content' => trim($_POST['content']),
                'title_err' => '',
                'content_err' => ''
            ];

            // gestion erreurs
            if(empty($data['title'])) {
                $data['title_err'] = 'veuillez entrer un titre';
            }
            if(empty($data['content'])) {
                $data['content_err'] = 'Veuillez entrer du contenu';
            }

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

    public function edit($id)
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize post array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => $id,
                'user_id' => $_SESSION['user_id'],
                'title' => trim($_POST['title']),
                'content' => trim($_POST['content']),
                'title_err' => '',
                'content_err' => ''
            ];

            // gestion erreurs
            if(empty($data['title'])) {
                $data['title_err'] = 'veuillez entrer un titre';
            }
            if(empty($data['content'])) {
                $data['content_err'] = 'Veuillez entrer du contenu';
            }

            // vérifie si il n'y a pas d'erreur
            if(empty($data['title_err']) && empty($data['content_err'])) {
                // valider
                if($this->postModel->updatePost($data)) {
                    flash('post_message', 'Le billet a été mis à jour');
                    header('Location: ' . URLROOT);

                } else {
                    die('une erreur est survenue');
                }
            } else {
                // affiche les messages d'erreurs
                $this->loadView('editPost', $data);
            }
        }else {
            // obtient le billet existant depuis le model
            $post = $this->postModel->getPostById($id);

            // Vérifie que l'auteur du post correspond avec l'utilisateur connecté
            if($post->getUserId() != $_SESSION['user_id']) {
                header('Location: '. URLROOT);
            }
            $data = [
                'id' => $id,
                'title' => $post->getTitle(),
                'content' => $post->getContent()
            ];

            $this->loadView('editPost', $data);
        }
    }

    public function delete($postId)
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // obtient le post existant depuis le model
            $post = $this->postModel->getPostById($postId);
            // vérifie que l'auteur du post correspond avec l'utilisateur connecté
            if($post->getUserId() != $_SESSION['user_id']) {
                header('Location: ' . URLROOT);
            }
            if($this->postModel->deletePost($postId)) {
                flash('post_message', 'La Billet a été supprimé');
                header('Location: ' . URLROOT);
            } else {
                die('la méthode delePost n\'a pas été appelé');
            }
        } else {
            header('Location: ' . URLROOT);
        }
    }
}