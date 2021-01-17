<?php


namespace app\core;


abstract class Migration
{
    public abstract function up();
    public abstract function down();

    protected function exec(string $sql) {
        Application::$app->db->pdo->exec($sql);
    }
}