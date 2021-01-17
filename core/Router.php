<?php

namespace app\core;

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
            $this->response->setStatusCode(404);
            return $this->renderView("_404");
        }

        if (is_string($callback)) {
            echo "Callback cannot be string";
            exit;
        }

        if(is_array($callback)) {
            $callback[0] = new $callback[0];
            Application::$app->controller = $callback[0];
        }

        return call_user_func($callback, $this->request);
    }

    public function renderView($view, $params = [])
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view, $params);

        return str_replace("{{content}}", $viewContent, $layoutContent);
    }

    protected function layoutContent()
    {
        $layout = Application::$app->controller->layout;
        ob_start();
        require_once(Application::$ROOT_DIR . "/views/layouts/$layout.php");
        return ob_get_clean();
    }

    protected function renderOnlyView($view, $params=[])
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        ob_start();
        require_once(Application::$ROOT_DIR . "/views/$view.php");
        return ob_get_clean();
    }
}
