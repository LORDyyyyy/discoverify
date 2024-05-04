<?php

declare(strict_types=1);

namespace Framework;

use Framework\Interfaces\{
    MiddlewareInterface,
    NonAPIValidation,
    APIValidation
};


class Router
{
    private array $routes = [];
    private array $middlewares = [];
    private array $errorHandler;

    private array $nonReadMethods = ['POST', 'PUT', 'DELETE', 'PATCH'];

    /**
     * Adds a new route to the router.
     *
     * @param string $method The HTTP method for the route.
     * @param string $path The path pattern for the route.
     * @param array $controller The controller for the route.
     * @param bool $isApi (optional) Indicates if the route is an API route. Default is false.
     * 
     * @return void
     */
    public function add(string $method, string $path, array $controller, bool $isApi = false)
    {
        $path = $this->normalizePath($path);

        $regexPath = preg_replace('#{[^/]+}#', '([^/]+)', $path);

        $this->routes[] = [
            'path' => $path,
            'method' => strtoupper($method),
            'controller' => $controller,
            'middlewares' => [],
            'regexPath' => $regexPath,
            'isAPI' => $isApi
        ];
    }

    /**
     * Normalization the path of the route, adding / on each side
     *
     * @param string $path the path of the route
     *
     * @return string the $path variable after modifying it
     */
    private function normalizePath(string $path): string
    {
        $path = trim($path, '/');
        $path = "/{$path}/";
        $path = preg_replace('#[/]{2,}#', '/', $path);

        return $path;
    }

    /**
     * Dispath the path and call the controller function and the Middlewares
     *
     * @param string $path the path of the route
     * @param string $method the method of the route
     * @param Container $container the container instance
     *
     * @return void
     */
    public function dispath(string $path, string $method, Container $container = null)
    {
        $path = $this->normalizePath($path);
        $method = strtoupper($_POST['_METHOD'] ?? $method);

        foreach ($this->routes as $route) {
            $paramsValues = [];
            $paramsKeys = [];
            if (
                !preg_match("#^{$route['regexPath']}$#", $path, $paramsValues) ||
                $route['method'] !== $method
            ) {
                continue;
            }

            if ($route['isAPI']) {
                header('HTTP_API_REQUEST');
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/json; charset=UTF-8');



                if (in_array($method, $this->nonReadMethods)) {
                    header('Access-Control-Allow-Methods: ' . $method);
                    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

                    $data = json_decode(file_get_contents('php://input'), true);
                    $_POST = $data ?? [];
                }
            }

            array_shift($paramsValues);

            preg_match_all('#{([^/]+)}#', $route['path'], $paramsKeys);

            $paramsKeys = $paramsKeys[1];

            $params = array_combine($paramsKeys, $paramsValues);
            $params['_REQUEST_METHOD'] = $method;

            [$class, $function] = $route['controller'];

            $controllerInstance = $container ?
                $container->resolve($class) :
                new $class;

            $action = fn ($params) => $controllerInstance->{$function}($params);

            $allMiddlewares = [...$route['middlewares'], ...$this->middlewares];

            foreach ($allMiddlewares as $middleware) {
                $middlewareInstance = $container ?
                    $container->resolve($middleware) :
                    new $middleware();

                if (($middlewareInstance instanceof APIValidation && !$route['isAPI'])
                    || ($middlewareInstance instanceof NonAPIValidation && $route['isAPI'])
                ) {
                    continue;
                }
                $action = fn ($params) => $middlewareInstance->process($action, $params);
            }

            $action($params);

            if ($route['isAPI'])
                exit;
            return;
        }

        $this->dispathNotFound($container, in_array($method, $this->nonReadMethods));
    }

    /**
     * Add a Global Middleware and add it to the Middleware list
     *
     * @param string $middleware The middleware function to be called
     * @return void
     */
    public function addMiddleware(string $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * Adds middlewares to the last added route.
     *
     * @param array $middleware The middlewares to be added.
     * @return void
     */
    public function addRouteMiddleware(array $middleware)
    {
        $path = array_key_last($this->routes);

        $this->routes[$path]['middlewares'] = [...$this->routes[$path]['middlewares'], ...$middleware];
    }

    /**
     * Sets the error handler controller.
     *
     * @param array $controller The error handler controller.
     * @return void
     */
    public function setErrorHandler(array $controller)
    {
        $this->errorHandler = $controller;
    }

    /**
     * Dispatches the "not found" error to the appropriate error handler.
     *
     * @param Container|null $container The dependency injection container (optional).
     * @param bool $isAPI Indicates if the request is an API request (optional).
     * @return void
     */
    public function dispathNotFound(?Container $container, ?bool $isAPI = false)
    {
        [$class, $function] = $this->errorHandler;

        $params = ['isAPI' => $isAPI];

        if ($isAPI) {
            header('HTTP_API_REQUEST');
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json; charset=UTF-8');
        }

        $controllerInstance = $container ?
            $container->resolve($class) :
            new $class;

        $action = fn ($params) => $controllerInstance->{$function}($params);

        foreach ($this->middlewares as $middleware) {
            $middlewareInstance = $container ?
                $container->resolve($middleware) :
                new $middleware();

            if (($middlewareInstance instanceof APIValidation && !$isAPI)
                || ($middlewareInstance instanceof NonAPIValidation && $isAPI)
            ) {
                continue;
            }
            $action = fn ($params) => $middlewareInstance->process($action, $params);
        }

        $action($params);

        if ($isAPI)
            exit;
    }
}
