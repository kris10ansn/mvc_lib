<?php


use app\core\Migration;

class m0003_add_unique_email_user extends Migration
{
    public function up()
    {
        $this->exec("ALTER TABLE user ADD CONSTRAINT unique_email UNIQUE KEY(email)");
    }

    public function down()
    {
        $this->exec("ALTER TABLE user DROP INDEX unique_email");
    }
}