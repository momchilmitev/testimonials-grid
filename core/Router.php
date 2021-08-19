<?php

class Router
{
    private $routes = [];

    public function setRoutes(array $routes)
    {
        $this->routes = $routes;
    }

    public function getFilename(string $url)
    {
        foreach ($this->routes as $route => $file) {
            if (strpos($url, $route) !== false) {
                return $file;
            } else {
                return $this->routes['not_found'];
            }
        }
    }
}
