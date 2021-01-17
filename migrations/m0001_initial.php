<?php


use app\core\Application;
use app\core\Migration;

class m0001_initial extends Migration
{
    public function up()
    {
        $SQL = "CREATE TABLE user (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL,
            username VARCHAR(255) NOT NULL,
            status TINYINT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB";

        $this->exec($SQL);
    }
    public function down()
    {
        $SQL = "DROP TABLE IF EXISTS user";
        $this->exec($SQL);
    }
}