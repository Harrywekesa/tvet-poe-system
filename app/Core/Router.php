<?php

namespace App\Core;

class Router
{
    protected $routes = [];

    private function addRoute($route, $controller, $action, $method)
    {
        $this->routes[$method][$route] = ['controller' => $controller, 'action' => $action];
    }

    public function get($route, $controller, $action)
    {
        $this->addRoute($route, $controller, $action, 'GET');
    }

    public function post($route, $controller, $action)
    {
        $this->addRoute($route, $controller, $action, 'POST');
    }


    public function dispatch($uri)
    {
        // Remove base path from URI (assuming /APOE/public)
        $scriptName = dirname($_SERVER['SCRIPT_NAME']); // /APOE/public
        $uri = str_replace($scriptName, '', $uri);
        $uri = '/' . trim($uri, '/');

        $method = $_SERVER['REQUEST_METHOD'];

        if (strpos($uri, '?') !== false) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }

        foreach ($this->routes[$method] as $route => $val) {
            // Convert route to regex: /user/{id} -> /user/([a-zA-Z0-9_]+)
            $pattern = "@^" . preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([a-zA-Z0-9_]+)', $route) . "$@D";

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Remove full match

                // Instantiate Controller
                $controllerClass = "App\\Controllers\\" . $val['controller'];
                $controller = new $controllerClass();
                call_user_func_array([$controller, $val['action']], $matches);
                return;
            }
        }

        echo "404 Not Found";
    }
}
