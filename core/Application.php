<?php

namespace app\core;

use app\models\User;

class Application
{
    public static string $ROOT_DIR;
    public string $layout = "main";
    public Router $router;
    public Request $request;
    public Response $response;
    public ?Controller $controller = null;
    public Session $session;
    public Database $db;
    public ?UserModel $user;
    public View $view;
    public string $userClass;
    public static Application $app;

    public function __construct(string $root, array $config)
    {
        self::$ROOT_DIR = $root;
        self::$app = $this;

        $this->db = new Database($config["db"]);
        $this->session = new Session();

        $userClass = $config["userClass"];
        $primaryValue = $this->session->get("user");

        if ($primaryValue) {
            $user = new $userClass();
            $primaryKey = $user->primaryKey();
            $this->user = $user->findOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }

        $this->view = new View();
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }

    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $exception) {
            $this->response->setStatusCode($exception->getCode());
            echo $this->view->render("_error", [
                "exception" => $exception
            ]);
        }
    }

    public function login(UserModel $user): bool
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};

        $this->session->set("user", $primaryValue);

        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove("user");
    }
}
