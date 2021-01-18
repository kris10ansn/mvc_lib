<?php

namespace app\core;

use app\core\exceptions\NotFoundException;

class Router
{
    protected array $routes = [];
    public Request $request;
    public Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    private function addRoute($method, $path, $callback)
    {
        $this->routes[$method][$path] = $callback;
    }

    public function get($path, $callback)
    {
        $this->addRoute("get", $path, $callback);
    }

    public function post($path, $callback)
    {
        $this->addRoute("post", $path, $callback);
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            throw new NotFoundException();
        }

        if (is_string($callback)) {
             return Application::$app->view->render($callback);
        }

        if(is_array($callback)) {
            $callback[0] = new $callback[0];
            Application::$app->controller = $callback[0];
            Application::$app->controller->action = $callback[1];

            foreach (Application::$app->controller->getMiddlewares() as $middleware) {
                $middleware->execute();
            }
        }

        return call_user_func($callback, $this->request, $this->response);
    }
}
