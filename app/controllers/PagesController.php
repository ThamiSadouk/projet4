<?php

class PagesController extends BaseController
{
    public function __construct()
    {

    }

    public function index() {
        $this->loadView('hello');
    }

    public function about() {
        echo 'hello world';
    }
}