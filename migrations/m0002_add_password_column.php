<?php


use app\core\Migration;

class m0002_add_password_column extends Migration
{
    public function up()
    {
        $this->exec("ALTER TABLE user ADD COLUMN password VARCHAR(512) NOT NULL");
    }

    public function down()
    {
        $this->exec("ALTER TABLE user DROP COLUMN password");
    }
}