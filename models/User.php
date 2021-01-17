<?php


namespace app\models;


use app\core\DBModel;

class User extends DBModel
{
    public const STATUS_INACTIVE = 0;
    public const STATUS_ACTIVE = 1;
    public const STATUS_DELETED = 2;

    public string $email = "";
    public string $username = "";
    public string $password = "";
    public int $status = self::STATUS_INACTIVE;

    public function save(): bool
    {
        $this->password = (string) password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
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
}