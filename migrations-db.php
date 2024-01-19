<?php

$dbConfig = require 'config/db.php';

$defaultDbConfig = $dbConfig['default'] ?? [];

return [
    'dbname' => $defaultDbConfig['dbname'],
    'user' => $defaultDbConfig['user'],
    'password' => $defaultDbConfig['password'],
    'host' => $defaultDbConfig['host'],
    'driver' => 'pdo_mysql',
];
