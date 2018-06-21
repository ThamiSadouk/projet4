<?php

use \App\Libraries\BaseController;

class PagesController extends BaseController
{
    public function __construct()
    {
        $this->postModel = $this->loadModel('PostManager');
    }

    public function index() {
        // appelle methode getpost dans models
        $posts = $this->postModel->getPosts();
        $data = [
            'posts' => $posts
        ];

        $this->loadView('index', $data);
    }

    public function showPost($postId) {
        $post = $this->postModel->getPostById($postId);
        $comments = $this->postModel->getComments($postId);
        $data = [
            'post' => $post,
            'comments' => $comments
        ];

        $this->loadView('postView', $data);
    }

    public function about() {
        $this->loadView('about', '');
    }
}