<?php

use \App\Libraries\BaseController;

class CommentsController extends BaseController
{
    public function __construct()
    {
        $this->commentModel = $this->loadModel('CommentManager');
    }

    public function add($postId)
    {

        // sanitize post array
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
            'postId' => $postId,
            'author' => trim($_POST['author']),
            'comment' => trim($_POST['comment'])
        ];

        if($this->commentModel->addComment($data)) {
            header('location: ' . URLROOT . '/PagesController/showPost/' . $postId);

        } else {
            die('Le commentaire n\'a pas été ajouté');
        }
    }
}