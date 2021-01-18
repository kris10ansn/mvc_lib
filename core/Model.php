<?php


namespace app\core;


use ReflectionClass;

abstract class Model
{
    public const RULE_REQUIRED = "required";
    public const RULE_EMAIL = "email";
    public const RULE_MIN = "min";
    public const RULE_MAX = "max";
    public const RULE_UNIQUE = "unique";

    public array $errors = [];

    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public abstract function rules(): array;

    public function labels(): array
    {
        return [];
    }

    public function getLabel(string $attribute): string
    {
        return $this->labels()[$attribute] ?? $attribute;
    }

    public function validate(): bool
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName = $rule;

                if (is_array($rule)) {
                    $ruleName = $rule[0];
                }

                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addError($attribute, self::RULE_REQUIRED);
                }

                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($attribute, self::RULE_EMAIL);
                }

                if ($ruleName === self::RULE_MIN && strlen($value) < $rule["min"]) {
                    $this->addError($attribute, self::RULE_MIN, $rule);
                }

                if ($ruleName === self::RULE_MAX && strlen($value) > $rule["max"]) {
                    $this->addError($attribute, self::RULE_MAX, $rule);
                }

                if ($ruleName === self::RULE_UNIQUE) {
                    $class = $rule["class"];
                    $uniqueAttribute = $rule["attribute"] ?? $attribute;
                    $tableName = $class::tableName();

                    $sql = "SELECT count(*) as users FROM $tableName WHERE $uniqueAttribute = :attr";
                    $statement = Application::$app->db->pdo->prepare($sql);
                    $statement->bindValue(":attr", $value);
                    $statement->execute();

                    $result = $statement->fetch();
                    if($result["users"] > 0) {
                        $this->addError($attribute, self::RULE_UNIQUE, [
                            "field" => $attribute,
                            "className" => (new ReflectionClass($this))->getShortName()
                        ]);
                    }
                }
            }
        }

        return empty($this->errors);
    }

    private function addError(string $attribute, string $rule, $params = [])
    {
        $message = $this->errorMessages()[$rule] ?? "";

        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }

        $this->errors[$attribute][$rule] = $message;
    }

    public function addErrorMessage(string $attribute, string $message)
    {
        $this->errors[$attribute][] = $message;
    }

    public function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => "This field is required",
            self::RULE_EMAIL => "This field must be a valid email address",
            self::RULE_MIN => "Needs to be a minimum of {min} characters",
            self::RULE_MAX => "Cannot be longer than {max} characters",
            self::RULE_UNIQUE => "{className} with this {field} already exists",
        ];
    }

    public function hasError($attribute): bool
    {
        return isset($this->errors[$attribute]);
    }

    public function getFirstError($attribute): string {
        $errors = $this->errors[$attribute];
        return $errors[array_key_first($errors)] ?? "";
    }
}