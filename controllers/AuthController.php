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
        $registerModel = new User();

        if ($request->getMethod() === "post") {
            $registerModel->loadData($request->getBody());

            if ($registerModel->validate() && $registerModel->register()) {
                return "Success";
            }
        }

        return $this->render("register", [
            "model" => $registerModel
        ]);
    }

    public function render($view, $params = [])
    {
        $this->setLayout("auth");
        return parent::render($view, $params);
    }
}