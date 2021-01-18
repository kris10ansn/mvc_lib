<?php


namespace app\core;
use Exception;
use PDOStatement;

abstract class DBModel extends Model
{
    public abstract function tableName(): string;
    public abstract function attributes(): array;
    public abstract function primaryKey(): string;

    public function findOne(array $where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);

        $selectors = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $sql = "SELECT * FROM $tableName WHERE $selectors";

        $statement = Application::$app->db->pdo->prepare($sql);

        foreach ($where as $key => $value) {
            $statement->bindValue(":$key", $value);
        }

        $statement->execute();
        return $statement->fetchObject(static::class);
    }

    public function save()
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
            return $pdo->lastInsertId();
        } catch (Exception $error) {
            echo "ERROR<br>" . $error;
            return false;
        }
    }
}