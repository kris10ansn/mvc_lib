<?php


use app\core\Migration;

class m0003_add_default_status_user extends Migration
{

    public function up()
    {
        $this->exec("ALTER TABLE user MODIFY COLUMN status TINYINT NOT NULL DEFAULT 0");
    }

    public function down()
    {
        $this->exec("ALTER TABLE user MODIFY COLUMN status TINYINT");
    }
}