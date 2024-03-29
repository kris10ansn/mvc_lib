<?php


namespace app\core;

use PDO;


class Database
{
    public PDO $pdo;

    public function __construct(array $config)
    {
        $dsn = $config["dsn"];
        $user = $config["user"];
        $password = $config["password"];

        $this->pdo = new PDO($dsn, $user, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function applyMigrations()
    {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();

        $files = scandir(Application::$ROOT_DIR . "/migrations");
        $migrations = array_diff($files, $appliedMigrations);
        $newMigrations = [];

        foreach ($migrations as $migration) {
            if ($migration == "." || $migration == "..") {
                continue;
            }

            require_once(Application::$ROOT_DIR . "/migrations/$migration");

            /** @var Migration $instance */
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className;

            $this->log("Applying $migration");

            $instance->up();

            $this->log("Applied $migration");

            array_push($newMigrations, $migration);
        }

        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            $this->log("All migrations are applied");
        }
    }

    private function createMigrationsTable()
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB");
    }

    private function getAppliedMigrations(): array
    {
        $statement = $this->pdo->prepare("SELECT migration FROM migrations");
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    private function saveMigrations(array $migrations)
    {
        $values = implode(",", array_map(fn($migration) => "('$migration')", $migrations));
        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES $values");
        $statement->execute();
    }

    public function log($message)
    {
        echo "DATABASE [ " . date("Y-m-d H:i:s") . " ]: " . $message . PHP_EOL;
    }
}