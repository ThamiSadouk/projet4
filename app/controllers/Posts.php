<?php

class Posts extends BaseController
{
    public function __construct()
    {
        $this->postModel = $this->loadModel('Post');
    }

    public function index()
    {
        // appelle methode getpost dans models
        $posts = $this->postModel->getPosts();
        $data = [
            'posts' => $posts
        ];

        $this->loadView('index', $data);
    }
}