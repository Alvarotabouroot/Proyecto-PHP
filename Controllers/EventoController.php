<?php

namespace Controllers;
use Controllers\ApiEventoController;
use Lib\Pages;


class EventoController{
    private ApiEventoController $apiEvento;
    private Pages $pages;

    public function __construct(){
        $this->apiEvento = new ApiEventoController();
        $this->pages = new Pages();
    }
}