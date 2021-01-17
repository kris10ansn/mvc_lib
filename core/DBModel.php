<?php


namespace app\core;
use Exception;
use PDOStatement;

abstract class DBModel extends Model
{
    public abstract function tableName(): string;
    public abstract function attributes(): array;

    public function save(): bool
    {
        try {
            $pdo = Application::$app->db->pdo;

            $tableName = $this->tableName();
            $attributes = $this->attributes();

            $attributes_str = implode(",", $attributes);
            $params_str = implode(",", array_map(fn($attr) => ":$attr", $attributes));

            $statement = $pdo->prepare("INSERT INTO $tableName ($attributes_str) VALUES ($params_str)");

            foreach ($attributes as $attribute) {
                $statement->bindValue(":$attribute", $this->{$attribute});
            }

            $statement->execute();
            return true;
        } catch (Exception $error) {
            echo "ERROR<br>" . $error;
            return false;
        }
    }
}