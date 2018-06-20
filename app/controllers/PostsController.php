<?php

class PostsController extends BaseController
{
    public function __construct()
    {
        $this->postModel = $this->loadModel('Post');
    }

    public function index()
    {

    }
}