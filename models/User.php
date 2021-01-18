<?php


namespace app\models;


use app\core\Application;
use app\core\DBModel;
use app\core\UserModel;

class User extends UserModel
{
    public const STATUS_INACTIVE = 0;
    public const STATUS_ACTIVE = 1;
    public const STATUS_DELETED = 2;

    public string $email = "";
    public string $username = "";
    public string $password = "";
    public int $status = self::STATUS_INACTIVE;
    public int $id;

    public function save()
    {
        $this->password = (string) password_hash($this->password, PASSWORD_DEFAULT);
        $this->id = parent::save();
        Application::$app->session->set("user", $this->id);
        return $this->id;
    }

    public function register(): bool
    {
        return $this->save();
    }

    public function rules(): array
    {
        return [
            "email" => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, "class" => self::class]],
            "username" => [self::RULE_REQUIRED, [self::RULE_MAX, "max" => 24], [self::RULE_MIN, "min"=>2]],
            "password" => [self::RULE_REQUIRED, [self::RULE_MIN, "min" => 4], [self::RULE_MAX, "max" => 128]],
        ];
    }

    public function tableName(): string
    {
        return "user";
    }

    public function primaryKey(): string {
        return "id";
    }


    public function attributes(): array
    {
        return ["username", "email", "password", "status"];
    }

    public function labels(): array
    {
        return [
            "email" => "E-mail",
            "username" => "Username",
            "password" => "Password"
        ];
    }

    public function getDisplayName(): string
    {
        return $this->username;
    }
}