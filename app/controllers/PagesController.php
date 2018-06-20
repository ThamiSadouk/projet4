<?php

class PagesController extends BaseController
{
    public function __construct()
    {
        $this->postModel = $this->loadModel('Post');
    }

    public function index() {
        // appelle methode getpost dans models
        $posts = $this->postModel->getPosts();

        $this->loadView('index', $posts);
    }

    public function about() {
        echo 'hello world';
    }
}