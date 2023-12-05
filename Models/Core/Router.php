<?php
namespace Core;


/**
 * Class Router
 * Handles routing operations based on HTTP methods and URIs.
 */
class Router
{
    /**
     * @var array Stores registered routes.
     */
    protected $routes = [];

    /**
     * Adds a route for a specific HTTP method.
     *
     * @param string $method The HTTP method.
     * @param string $uri The URI.
     * @param string $controller The controller associated with the route.
     */
    public function add($method, $uri, $controller)
    {
        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method
        ];
    }

    /**
     * Adds a GET route.
     *
     * @param string $uri The URI for the GET request.
     * @param string $controller The controller for the GET request.
     */
    public function get($uri, $controller)
    {
        $this->add('GET', $uri, $controller);
    }

    /**
     * Adds a POST route.
     *
     * @param string $uri The URI for the POST request.
     * @param string $controller The controller for the POST request.
     */
    public function post($uri, $controller)
    {
        $this->add('POST', $uri, $controller);
    }

    /**
     * Adds a DELETE route.
     *
     * @param string $uri The URI for the DELETE request.
     * @param string $controller The controller for the DELETE request.
     */
    public function delete($uri, $controller)
    {
        $this->add('DELETE', $uri, $controller);
    }

    /**
     * Adds an UPDATE route.
     *
     * @param string $uri The URI for the UPDATE request.
     * @param string $controller The controller for the UPDATE request.
     */
    public function update($uri, $controller)
    {
        $this->add('UPDATE', $uri, $controller);
    }

    /**
     * Adds an EDIT route.
     *
     * @param string $uri The URI for the EDIT request.
     * @param string $controller The controller for the EDIT request.
     */
    public function edit($uri, $controller)
    {
        $this->add('EDIT', $uri, $controller);
    }

    /**
     * Adds a CREATE route.
     *
     * @param string $uri The URI for the CREATE request.
     * @param string $controller The controller for the CREATE request.
     */
    public function create($uri, $controller)
    {
        $this->add('CREATE', $uri, $controller);
    }


    /**
     * Adds a SEARCH route.
     *
     * @param string $uri The URI for the SEARCH request.
     * @param string $controller The controller for the SEARCH request.
     */
    public function search($uri, $controller)
    {
        $this->add('SEARCH', $uri, $controller);
    }

    /**
     * Adds a FILTER_AND_ORDER route.
     *
     * @param string $uri The URI for the FILTER_AND_ORDER request.
     * @param string $controller The controller for the FILTER_AND_ORDER request.
     */
    public function filterAndOrder($uri, $controller)
    {
        $this->add('FIORD', $uri, $controller);
    }

    /**
     * Routes the request based on URI and method.
     *
     * @param string $uri The URI to route.
     * @param string $method The HTTP method to check against.
     * @return mixed Returns the result of the controller execution.
     */
    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === strtoupper($method)) {
                return require $route['controller'];
            }
        }

        $this->abort();
    }

    /**
     * Aborts the current request.
     *
     * @param int $code The HTTP response code.
     */
    protected function abort($code = 404)
    {
        http_response_code($code);

        require_once("Views/{$code}.php");

        die();
    }
}