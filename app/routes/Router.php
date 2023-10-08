<?php

namespace Framework\routes;

use Exception;
use Framework\config\Dump;
use Framework\services\EasyRouteParser;

class Router
{
    use Dump;
    protected  $requestedMethod;
    protected  $requestedUrl;
    protected  $routes = [];
    protected  $currentPrefix = ''; // Define the current route prefix
    protected  $parsed;
    public function __construct()
    {
        $this->load();
    }
    public function load()
    {
        $this->parsed = new EasyRouteParser();
        $this->fetchRequestInfo();
    }

    private function fetchRequestInfo()
    {
        // Get the HTTP request method (e.g., GET, POST)
        $this->requestedMethod = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : '';

        // Get the URL path
        $this->requestedUrl = isset($_SERVER['REQUEST_URI']) ? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) : '';
        // Validate the request URL
        if (!preg_match('/^[a-zA-Z0-9-\/]+$/', $this->requestedUrl)) {
            // Log the error
            error_log('Invalid request URL: ' . $this->requestedUrl);
        }
        $parsedUrl = $this->parsed->parsePlaceholders($this->requestedUrl);
        $parsedUrl = $this->parsed->parsePlaceholders($this->requestedUrl);

        // Check if the parsed URL is valid
        if (empty($parsedUrl)) {
            // Log the error
            error_log('Invalid parsed URL: ' . $parsedUrl);
        }
        // Set the parsed URL on the Router class
        $this->parsed = $parsedUrl;
    }

    public function get($route, $handler)
    {
        $this->addRoute('GET', $route, $handler);
    }

    public function post($route, $handler)
    {
        $this->addRoute('POST', $route, $handler);
    }

    // Add a method for defining a group of routes
    public function group($prefix, $callback)
    {
        // Save the current route prefix
        $previousPrefix = $this->currentPrefix;

        // Set the new route prefix
        $this->currentPrefix = $previousPrefix . $prefix;

        // Execute the callback function
        call_user_func($callback, $this);

        // Restore the previous route prefix
        $this->currentPrefix = $previousPrefix;
    }

    private function addRoute($method, $route, $handler)
    {
        // Add the current prefix to the route
        $route = $this->currentPrefix . $route;

        $this->routes[] = [
            'method' => $method,
            'route' => $route,
            'handler' => $handler,
        ];
    }

    public function route()
    {
        // Get the parsed URL from the Router class
        try {
            foreach ($this->routes as $route) {
                if ($route['method'] === $this->requestedMethod) {
                    $pattern = '/^' . str_replace(['/', '{id}'], ['\/', '(\d+)'], $route['route']) . '$/';
                    if (preg_match($pattern, $this->requestedUrl, $matches)) {
                        $handler = $route['handler'];

                        // Check if the handler is callable
                        if (is_callable($handler)) {
                            $handler();
                            return;
                        } elseif (is_array($handler) && count($handler) === 2 && method_exists($handler[0], $handler[1])) {
                            $controllerClass = ucfirst($handler[0]);
                            $method = ucfirst($handler[1]);
                            $controller = new $controllerClass();
                            // Pass the extracted id as a parameter to the controller method
                            if (isset($matches[1])) {
                                $controller->$method($matches[1]);
                            } else {
                                $controller->$method();
                            }
                            return;
                        }
                    }
                }
            }
        } catch (Exception $e) {
            error_log('Something wrong with URL: ' . $e->getMessage());
        }

        // Handle 404 Not Found
        http_response_code(404);
        echo 'Page Not Found';
    }
}
