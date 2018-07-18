<?php

namespace App\Controllers;

use App\Libraries\BaseController;
use App\Entity\Post;

class PostsController extends BaseController
{
    use Comments;

    public function __construct()
    {
        $this->userModel = $this->loadModel('UserManager');
        $this->postModel = $this->loadModel('PostManager');
        $this->commentModel = $this->loadModel('CommentManager');
    }

    /**
     * page d'accueil, affiche les 5 derniers posts
     */
    public function index() {
        // appelle methode getpost dans models
        $posts = $this->postModel->getPosts();
        $data = [
            'posts' => $posts
        ];

        $this->loadView('index', $data);
    }

    /**
     * Affiche le billet et les commentaires à l'id correspondant, si posts est null, envoi une erreur
     * @param $postId int
     */
    public function showPost($postId = null)
    {
        // obtient le billet correspondant à son id
        $post = $this->postModel->getPostById($postId);
        if (is_bool($post)) {
            $this->loadView('error');
        }
        $comments = $this->postModel->getComments($postId);

        $data = [
            'post' => $post,
            'comments' => $comments
        ];
        // gère les requêtes POST
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if (isset($_POST['comment_signalement'])) {
                $this->commentModel->signalComment($_POST['comment_signalement']);
                header('location: ' . URLROOT . '/postsController/showPost/' . $postId);
            } else {
                // appelle methode ajout commentaire
                $this->addComment($postId);
                // affiche les erreurs
                $this->loadView('postView', $data, $this->dataForm);
            }
        }
        $this->loadView('postView', $data, $this->dataForm);
    }

    public function add()
    {
        if (isLoggedIn())
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $data = [
                    'userId' => $_SESSION['user_id'],
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

                if(empty($data['title_err']) && empty($data['content_err'])) {
                    // valider
                    $post = new Post($data);

                    if($this->postModel->addPost($post)) {
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
        } else {
            $this->loadView('error');
        }
    }

    public function edit($id = null)
    {
        if(isLoggedIn())
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $data = [
                    'id' => $id,
                    'userId' => $_SESSION['user_id'],
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
                    $post = new Post($data);

                    if($this->postModel->updatePost($post)) {
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
        } else {
            $this->loadView('error');
        }
    }

    public function delete($postId = null)
    {
        if(isLoggedIn()) {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                // obtient le post existant depuis le model
                $post = $this->postModel->getPostById($postId);
                // vérifie que l'auteur du post correspond avec l'utilisateur connecté
                if($post->getUserId() != $_SESSION['user_id']) {
                    header('Location: ' . URLROOT);
                }
                if($this->postModel->deletePost($postId)) {
                    // supprime les commentaires correspondants au post
                    $commentManager = $this->loadModel('CommentManager');
                    $commentManager->deleteComments($postId);

                    flash('post_message', 'La Billet a été supprimé');
                    header('Location: ' . URLROOT);
                } else {
                    die('la méthode delePost n\'a pas été appelé');
                }
            } else {
                $this->loadView('error');
            }
        } else {
            $this->loadView('error');
        }
    }
}