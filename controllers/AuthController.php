<?php


namespace app\controllers;


use app\core\Controller;
use app\core\Request;
use app\models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if ($request->getMethod() === "post") {
            return "Handle post";
        }

        return $this->render("login");
    }

    public function register(Request $request)
    {
        $user = new User();

        if ($request->getMethod() === "post") {
            $user->loadData($request->getBody());

            if ($user->validate() && $user->register()) {
                return "Success";
            }
        }

        return $this->render("register", [
            "model" => $user
        ]);
    }

    public function render($view, $params = [])
    {
        $this->setLayout("auth");
        return parent::render($view, $params);
    }
}