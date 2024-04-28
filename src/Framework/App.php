<?php

declare(strict_types=1);

namespace Framework;

class App
{
    private Router $router;
    private Container $container;

    public function __construct(string $containerDefinitiosnPath = null)
    {
        $this->router = new Router();
        $this->container = new Container();

        if ($containerDefinitiosnPath) {
            $containerDefinitios = include $containerDefinitiosnPath;
            $this->container->addDefinitions($containerDefinitios);
        }
    }

    /**
     * Start running the application and decide the paths
     *
     * @return void
     */
    public function run(): void
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        $this->router->dispath($path, $method, $this->container);
    }

    /**
     * Add a GET route in the routers list
     *
     * @param string $path The path of the router
     * @param array $controller Array contains the controller class name and the function
     * @param bool $isAPI If the route is an API route
     *
     * @return App
     */
    public function get(string $path, array $controller, ?bool $isAPI = false): App
    {
        $this->router->add('GET', $path, $controller, $isAPI);

        return $this;
    }

    /**
     * Add a POST route in the routers list
     *
     * @param string $path The path of the router
     * @param array $controller Array contains the controller class name and the function
     * @param bool $isAPI If the route is an API route
     *
     * @return App
     */
    public function post(string $path, array $controller, bool $isAPI = false): App
    {
        $this->router->add('POST', $path, $controller, $isAPI);

        return $this;
    }

    /**
     * Add a DELETE route in the routers list
     *
     * @param string $path The path of the router
     * @param array $controller Array contains the controller class name and the function
     * @param bool $isAPI If the route is an API route
     *
     * @return App 
     */
    public function delete(string $path, array $controller, ?bool $isAPI = false): App
    {
        $this->router->add('DELETE', $path, $controller, $isAPI);

        return $this;
    }

    /**
     * Add a PUT route in the routers list
     *
     * @param string $path The path of the router
     * @param array $controller Array contains the controller class name and the function
     * @param bool $isAPI If the route is an API route
     *
     * @return App 
     */
    public function put(string $path, array $controller, ?bool $isAPI = false): App
    {
        $this->router->add('PUT', $path, $controller, $isAPI);

        return $this;
    }

    /**
     * Add a PATCH route in the routers list
     *
     * @param string $path The path of the router
     * @param array $controller Array contains the controller class name and the function
     * @param bool $isAPI If the route is an API route
     *
     * @return App 
     */
    public function patch(string $path, array $controller, ?bool $isAPI = false): App
    {
        $this->router->add('PATCH', $path, $controller, $isAPI);

        return $this;
    }

    /**
     * Add a Middleware and use it in any route.
     *
     * @param string $middleware the middleware function to be called
     *
     * @return void
     */
    public function addMiddleware(string $middleware): void
    {
        $this->router->addMiddleware($middleware);
    }

    /**
     * Adds middlewares to a route.
     *
     * @param array $middleware The middlewares to add.
     * @return void
     */
    public function add(array $middleware): void
    {
        $middleware = array_reverse($middleware);
        $this->router->addRouteMiddleware($middleware);
    }

    /**
     * Sets the error handler for the application.
     *
     * @param array $controller The error handler controller.
     * @return void
     */
    public function setErrorHandler(array $controller): void
    {
        $this->router->setErrorHandler($controller);
    }
}
