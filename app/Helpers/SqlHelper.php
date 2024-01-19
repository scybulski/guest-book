<?php

namespace App\Helpers;

class SqlHelper
{
    public static function buildInsertSql(
        string $table,
        array $keys,
    ): string {
        $sql = "INSERT INTO {$table} ("
            . implode(', ', $keys)
            . ') VALUES ('
            . implode(', ', array_map(
                fn (string $key): string => ":{$key}",
                $keys,
            ))
            . ');';

        return $sql;
    }

    public static function buildUpdateSql(
        string $primaryKeyName,
        string $table,
        array $keys,
    ): string {
        $sql = "UPDATE {$table} SET "
            . implode(', ', array_map(
                fn (string $key): string => "{$key} = :{$key}",
                $keys,
            ))
            . "WHERE {$primaryKeyName} = :{$primaryKeyName};";

        return $sql;
    }
}
