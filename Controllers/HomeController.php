<?php

namespace Controllers;
use Lib\Pages;

class HomeController{
    private Pages $pages;

    public function __construct(){
        $this->pages = new Pages();
    }
    public function home(){
        $this->pages->render('home/index');
    }
}


