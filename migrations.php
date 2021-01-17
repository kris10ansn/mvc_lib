<?php

require_once(__DIR__ . "/vendor/autoload.php");

use Dotenv\Dotenv;
use app\core\Application;

$root = __DIR__;

$dotenv = Dotenv::createImmutable($root);
$dotenv->load();

$config = [
    "db" => [
        "dsn" => $_ENV["DB_DSN"],
        "user" => $_ENV["DB_USER"],
        "password" => $_ENV["DB_PASSWORD"],
    ]
];

$app = new Application($root, $config);
$app->db->applyMigrations();

