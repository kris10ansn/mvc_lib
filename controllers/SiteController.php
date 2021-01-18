<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\ContactForm;

class SiteController extends Controller
{
    public function home()
    {
        $params = [
            "name" => "Hello World"
        ];

        return $this->render("home", $params);
    }

    public function contact(Request $request, Response $response)
    {
        $contact = new ContactForm();
        if ($request->getMethod() === "post") {
            $contact->loadData($request->getBody());
            if ($contact->validate() && $contact->send()) {
                Application::$app->session->setFlash("success", "Thanks for contacting us.");
                $response->redirect("/");
            }
        }
        return $this->render("contact", [
            "model" => $contact
        ]);
    }
}
