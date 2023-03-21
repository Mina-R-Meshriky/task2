<?php

declare(strict_types=1);

namespace App\Helpers\Database;

use PDO;

class Database
{
    protected static ?Database $instance = null;
    private PDO $connection;

    public static function getInstance(?array $config = null)
    {
        if (self::$instance === null) {
            self::$instance = new self($config);
        }

        return self::$instance;
    }

    final protected function __clone()
    {
    }

    final protected function __wakeup(): void
    {
    }

    /**
     * @param  array<string>  $config
     */
    final protected function __construct(array $config)
    {
        $dsn = 'mysql:'.http_build_query($config, '', ';');
        $this->connection = new PDO($dsn);
        $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    /**
     * @return false|\PDOStatement
     */
    public function query(string $query, ?array $params = [])
    {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }
}
