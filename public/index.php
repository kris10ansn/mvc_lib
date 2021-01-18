<?php

require_once(__DIR__ . "/../vendor/autoload.php");

use app\models\User;
use Dotenv\Dotenv;
use app\core\Application;
use app\controllers\AuthController;
use app\controllers\SiteController;

$root = dirname(__DIR__);

$dotenv = Dotenv::createImmutable($root);
$dotenv->load();

$config = [
    "userClass" => User::class,
    "db" => [
        "dsn" => $_ENV["DB_DSN"],
        "user" => $_ENV["DB_USER"],
        "password" => $_ENV["DB_PASSWORD"],
    ],
];

$app = new Application($root, $config);

$app->router->get("/", "home");

$app->router->get("/contact", [SiteController::class, "contact"]);
$app->router->post("/contact", [SiteController::class, "contact"]);

$app->router->get("/register", [AuthController::class, "register"]);
$app->router->post("/register", [AuthController::class, "register"]);

$app->router->get("/login", [AuthController::class, "login"]);
$app->router->post("/login", [AuthController::class, "login"]);

$app->router->post("/logout", [AuthController::class, "logout"]);

$app->router->get("/profile", [AuthController::class, "profile"]);

$app->run();
