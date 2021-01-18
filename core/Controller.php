<?php


namespace app\core;


use app\core\middlewares\Middleware;

abstract class Controller
{
    /** @var Middleware[] $middlewares  */
    protected array $middlewares = [];
    public string $layout = "main";
    public string $action;

    public function render($view, $params = [])
    {
        return Application::$app->view->render($view, $params);
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function registerMiddleware(Middleware $middleware)
    {
        array_push($this->middlewares, $middleware);
    }

    /**
     * @return Middleware[]
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}