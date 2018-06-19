<?php

class PagesController extends BaseController
{
    public function __construct()
    {

    }

    public function index() {
        echo 'home page';
    }

    public function about() {
        echo 'hello world';
    }
}