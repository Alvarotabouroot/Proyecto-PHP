<?php

namespace Lib;

class Router2
{
    public array $getRoutes = [];
    public array $postRoutes = [];

    public function get($url, $fn)
    {
        
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }

    public function comprobarRutas()
    {
        $url_actual = $_SERVER['REQUEST_URI'] ?? '/';
        $url_actual = preg_replace("/\/cofradia\/public\//",'',$_SERVER['REQUEST_URI']);
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            $fn = $this->getRoutes[$url_actual] ?? null;
        } else {
            $fn = $this->postRoutes[$url_actual] ?? null;
        }

        if ( $fn ) {
            call_user_func($fn, $this);
        } else {
            header('Location: /404');
        }
    }
}
