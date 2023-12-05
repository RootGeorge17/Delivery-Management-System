<?php
namespace Core;

class Router
{
    protected $routes = [];

    public function add($method, $uri, $controller)
    {
        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method
        ];
    }

    public function get($uri, $controller)
    {
        $this->add('GET', $uri, $controller);
    }

    public function post($uri, $controller)
    {
        $this->add('POST', $uri, $controller);
    }

    public function delete($uri, $controller)
    {
        $this->add('DELETE', $uri, $controller);
    }

    public function update($uri, $controller)
    {
        $this->add('UPDATE', $uri, $controller);
    }

    public function edit($uri, $controller)
    {
        $this->add('EDIT', $uri, $controller);
    }

    public function create($uri, $controller)
    {
        $this->add('CREATE', $uri, $controller);
    }

    public function search($uri, $controller)
    {
        $this->add('SEARCH', $uri, $controller);
    }

    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === strtoupper($method)) {
                return require $route['controller'];
            }
        }

        $this->abort();
    }

    protected function abort($code = 404)
    {
        http_response_code($code);

        require_once("Views/{$code}.php");

        die();
    }
}