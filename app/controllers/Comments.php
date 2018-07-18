<?php

namespace App\Controllers;

use App\Entity\Comment;

trait Comments
{
    public $dataForm = [
            'author' => '',
            'comment' => '',
        ];

    public function addComment($postId)
    {
            $this->dataForm = [
                'postId' => $postId,
                'author' => trim($_POST['author']),
                'comment' => trim($_POST['comment']),
                'author_err' => '',
                'comment_err' => ''
            ];

            // gestion erreurs
            if (empty($this->dataForm['author'])) {
                $this->dataForm['author_err'] = 'veuillez entrer un nom';
            }
            if (empty($this->dataForm['comment'])) {
                $this->dataForm['comment_err'] = 'Veuillez entrer du contenu';
            }
            if (empty($this->dataForm['author_err']) && empty($this->dataForm['comment_err'])) {
                // valider
                $comment = new Comment($this->dataForm);
                if ($this->commentModel->addComment($comment)) {
                    header('location: ' . URLROOT . '/PostsController/showPost/' . $postId);
                } else {
                    die('une erreur est survenue');
                }
            } else {
                // affiche les messages d'erreurs
                return $this->dataForm;
            }
    }
}