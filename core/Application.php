<?php

namespace app\core;

class Application
{
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    public Controller $controller;
    public Session $session;
    public Database $db;
    public static Application $app;

    public function __construct(string $root, array $config)
    {
        self::$ROOT_DIR = $root;
        self::$app = $this;

        $this->db = new Database($config["db"]);
        $this->session = new Session();

        $this->request = new Request();
        $this->response = new Response();

        $this->router = new Router($this->request, $this->response);

    }

    public function run()
    {
        echo $this->router->resolve();
    }
}
