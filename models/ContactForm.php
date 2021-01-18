<?php


namespace app\models;


use app\core\Model;

class ContactForm extends Model
{
    public string $subject = "";
    public string $email = "";
    public string $body = "";

    public function send(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "subject" => [self::RULE_REQUIRED],
            "email" => [self::RULE_REQUIRED, self::RULE_EMAIL],
            "body" => [self::RULE_REQUIRED]
        ];
    }

    public function labels(): array
    {
        return [
            "subject" => "Subject",
            "email" => "Enter your E-mail",
            "body" => "Body"
        ];
    }
}