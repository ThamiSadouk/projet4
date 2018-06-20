<?php

class PostsController
{
    public function __construct()
    {
        $this->postModel = $this->loadModel('Post');
    }

    public function index()
    {

    }
}