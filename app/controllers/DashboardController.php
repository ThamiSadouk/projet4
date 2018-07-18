<?php

namespace App\Controllers;

use \App\Libraries\BaseController;

class DashboardController extends BaseController
{
    public function __construct()
    {
        $this->boardModel = $this->loadModel('DashboardManager');
    }

    public function dashboard()
    {
        if(isLoggedIn()) {
            $tables = $this->boardModel->inTable();

            $traduction = [
                'comments' => 'commentaires',
                'members' => 'Administrateur',
                'posts' => 'billets'
                ];
            $comments = $this->boardModel->getComments();

            $data = [
                'traduction' => $traduction,
                'tables' => $tables,
                'comments' => $comments
            ];
            $this->loadView('dashboard', $data);
        }
    }

    public function see($id)
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($this->boardModel->seeComment($id)) {
                flash('post_message', 'Le commentaire a été validé');
                header('Location: ' . URLROOT . '/dashboardController/dashboard');
            } else {
                die('une erreur s\'est produite');
            }
        } else {
            header('Location: ' . URLROOT . '/dashboardController/dashboard');
        }
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->boardModel->deleteComment($id)) {
                flash('post_message', 'Le commentaire a été supprimé');
                header('Location: ' . URLROOT . '/dashboardController/dashboard');
            } else {
                die('une erreur s\'est produite');
            }
        } else {
            header('Location: ' . URLROOT);
        }
    }
}