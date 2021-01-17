<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;

class SiteController extends Controller
{
    public function home()
    {
        $params = [
            "name" => "Hello World"
        ];

        return $this->render("home", $params);
    }

    public function contact(Request $request)
    {
        if ($request->getMethod() === "post") {
            return "handling request...";
        }
        return $this->render("contact");
    }
}
