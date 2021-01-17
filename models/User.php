<?php


namespace app\models;


use app\core\DBModel;

class User extends DBModel
{
    public string $email = "";
    public string $username = "";
    public string $password = "";

    public function register(): bool
    {
        return $this->save();
    }

    public function rules(): array
    {
        return [
            "email" => [self::RULE_REQUIRED, self::RULE_EMAIL],
            "username" => [self::RULE_REQUIRED, [self::RULE_MAX, "max" => 24], [self::RULE_MIN, "min"=>2]],
            "password" => [self::RULE_REQUIRED, [self::RULE_MIN, "min" => 4], [self::RULE_MAX, "max" => 128]],
        ];
    }

    public function tableName(): string
    {
        return "user";
    }

    public function attributes(): array
    {
        return ["username", "email", "password"];
    }
}