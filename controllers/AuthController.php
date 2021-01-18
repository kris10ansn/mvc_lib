<?php


namespace app\controllers;


use app\core\Application;
use app\core\Controller;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;
use app\models\LoginForm;
use app\models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleWare(new AuthMiddleWare(["profile"]));
    }

    public function login(Request $request, Response $response)
    {
        $loginForm = new LoginForm();

        if ($request->getMethod() === "post") {
            $loginForm->loadData($request->getBody());

            if ($loginForm->validate() && $loginForm->login()) {
                $username = Application::$app->user->getDisplayName();
                Application::$app->session->setFlash("success", "Welcome back, $username!");
                $response->redirect("/");
            }
        }

        return $this->render("login", [
            "model" => $loginForm
        ]);
    }

    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect("/");
    }

    public function register(Request $request, Response $response)
    {
        $user = new User();

        if ($request->getMethod() === "post") {
            $user->loadData($request->getBody());
            if ($user->validate() && $user->register()) {
                Application::$app->session->setFlash("success", "Account registered!");
                $response->redirect("/");
            }
        }

        return $this->render("register", [
            "model" => $user
        ]);
    }

    public function profile()
    {
        return $this->render("profile");
    }

    public function render($view, $params = [])
    {
        $this->setLayout("main");
        return parent::render($view, $params);
    }
}