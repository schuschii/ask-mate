<?php

namespace App\Core;

class Router
{
    private array $routes = [];
    private object $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    /**
     * Add a route to the router.
     *
     * @param string $method HTTP method (GET, POST, etc.).
     * @param string $path URL pattern (e.g., "/home", "/user/{id}").
     * @param callable|array $handler Controller method or callback function.
     */
    public function add(string $method, string $path, $handler): void
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $this->normalizePath($path),
            'handler' => $handler
        ];
    }

    /**
     * Dispatch the request to the appropriate controller/method.
     */
    public function dispatch(): void
    {
        $requestUri = $this->normalizePath($_SERVER['REQUEST_URI']);
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            $params = [];
            if ($this->match($route['path'], $requestUri, $params) && $route['method'] === $requestMethod) {
                $this->execute($route['handler'], $params);
                return;
            }
        }

        http_response_code(404);
        echo "404 - Not Found";
    }

    /**
     * Normalize the path by trimming slashes and ignoring query strings.
     */
    private function normalizePath(string $path): string
    {
        return rtrim(explode('?', $path)[0], '/');
    }

    /**
     * Match the request URI with a route pattern and extract parameters.
     */
    private function match(string $routePath, string $requestPath, array &$params): bool
    {
        $routeParts = explode('/', $routePath);
        $requestParts = explode('/', $requestPath);

        if (count($routeParts) !== count($requestParts)) {
            return false;
        }

        $params = [];
        foreach ($routeParts as $index => $part) {
            if (preg_match('/^\{(.+)\}$/', $part, $matches)) {
                $params[$matches[1]] = $requestParts[$index]; // Extract dynamic parameter
            } elseif ($part !== $requestParts[$index]) {
                return false;
            }
        }

        return true;
    }

    /**
     * Execute the matched route's handler.
     */
    private function execute($handler, array $params): void
    {
        if (is_callable($handler)) {
            call_user_func_array($handler, $params);
        } elseif (is_array($handler) && count($handler) === 2) {
            [$controllerName, $method] = $handler;
            $controller = new $controllerName($this->pdo);
            call_user_func_array([$controller, $method], $params);
        } else {
            throw new \Exception("Invalid route handler.");
        }
    }
}
