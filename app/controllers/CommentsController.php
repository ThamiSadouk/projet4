<?php

use \App\Libraries\BaseController;

class CommentsController extends BaseController
{
    public function __construct()
    {
        $this->postModel = $this->loadModel('CommentManager');
    }

    public function add($postId)
    {
        $data = [
            'postId' => $postId,
            'author' => trim($_POST['author']),
            'comment' => trim($_POST['comment'])
        ];

        if($this->postModel->addComment($data) == false) {
            die('Something went wrong');
        } else {
            header('location: ' . URLROOT . '/PagesController/showPost/' . $postId);
        }
    }
}