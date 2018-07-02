<?php

use \App\Libraries\BaseController;

class PagesController extends BaseController
{
    public function __construct()
    {
        $this->postModel = $this->loadModel('PostManager');
        $this->commentModel = $this->loadModel('CommentManager');
    }

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
     * @param $postId
     */
    public function showPost($postId) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once 'CommentsController.php';

            $commentsController = new CommentsController();
            $commentsController->add($postId);
            if (isset($_POST['comment_signalement'])) {
                $this->commentModel->signalComment($_POST['comment_signalement']);
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