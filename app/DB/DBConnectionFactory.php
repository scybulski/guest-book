<?php

namespace App\DB;

use PDO;

class DBConnectionFactory
{
    private static ?self $factory = null;

    private array $connections = [];

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance(): self
    {
        return self::$factory
            ?? self::$factory = new self();
    }

    public function getConnection(string $name = 'default'): PDO
    {
        return $this->connections[$name]
            ?? ($this->connections[$name] = $this->createConnectoin($name));
    }

    protected function createConnectoin(string $name): PDO
    {
        $config = $this->getConfig($name);

        $dbname = $config['dbname'] ?? null;
        $user = $config['user'] ?? null;
        $password = $config['password'] ?? null;
        $host = $config['host'] ?? null;
        $dbms = $config['dbms'] ?? null;

        return new PDO("{$dbms}:host={$host};dbname={$dbname}", $user, $password);
    }

    protected function getConfig(string $connectionName): array
    {
        $dbConfig = require 'config/db.php';

        return $dbConfig[$connectionName] ?? [];
    }
}
