<?php

use \App\Libraries\BaseController;


/**
 * Class PagesController
 */
class PagesController extends BaseController
{

    public function __construct()
    {
        $this->postModel = $this->loadModel('PostManager');
        $this->commentModel = $this->loadModel('CommentManager');
    }


    /**
     * représente la page d'accueil, affiche les 5 derniers posts
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
     * Affiche le billet et les commentaires à l'id correspondant
     * @param $postId int
     */
    public function showPost($postId) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once 'CommentsController.php';

            if(isset($_POST['author']) && isset($_POST['comment'])) {
                $commentsController = new CommentsController();
                $commentsController->add($postId);
            }

            if (isset($_POST['comment_signalement'])) {
                $this->commentModel->signalComment($_POST['comment_signalement']);
                header('location: ' . URLROOT . '/PagesController/showPost/' . $postId);
            }

        } else {
            $post = $this->postModel->getPostById($postId);
            if(is_bool($post)) {
                return $this->loadView('error');
            }
            $comments = $this->postModel->getComments($postId);
            $data = [
                'post' => $post,
                'comments' => $comments
            ];
            $this->loadView('postView', $data);
        }
    }
}