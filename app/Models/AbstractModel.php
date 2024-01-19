<?php

namespace App\Models;

use App\DB\DBConnectionFactory;
use App\Helpers\SqlHelper;
use App\Models\Annotations\ModelField;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionProperty;
use stdClass;

abstract class AbstractModel
{
    protected string $table;

    final public function __construct()
    {
    }

    public static function fromDbRecord(array $dbRecord): static
    {
        $model = new static();

        $fields = static::getModelFields();

        array_walk(
            $fields,
            function (string $field) use ($dbRecord, $model): void {
                $model->$field = $dbRecord[$field];
            }
        );

        return $model;
    }

    public static function getModelFields(): array
    {
        $reflectionClass = new ReflectionClass(static::class);

        $reflectionProperties = $reflectionClass->getProperties(ReflectionProperty::IS_PUBLIC);

        return array_map(
            fn (ReflectionProperty $reflectionProperty): string => $reflectionProperty->getName(),
            array_filter(
                $reflectionProperties,
                fn (ReflectionProperty $reflectionProperty): bool => !!sizeof($reflectionProperty->getAttributes(ModelField::class)),
            ),
        );
    }

    public static function getPrimaryKey(): string
    {
        $reflectionClass = new ReflectionClass(static::class);

        $reflectionProperties = $reflectionClass->getProperties(ReflectionProperty::IS_PUBLIC);

        $primaryKeyReflectionProperties = array_values(
            array_filter(
                $reflectionProperties,
                fn (ReflectionProperty $reflectionProperty): bool => !!sizeof(
                    array_filter(
                        $reflectionProperty->getAttributes(ModelField::class),
                        fn (ReflectionAttribute $reflectionAttribute): bool => $reflectionAttribute->newInstance()->isPrimary,
                    ),
                ),
            )
        );

        return $primaryKeyReflectionProperties[0]->getName();
    }

    public function save(): void
    {
        $primaryKey = $this->getPrimaryKey();

        $dbConnection = DBConnectionFactory::getInstance()->getConnection();

        $fillables = $this->getFillables();

        $values = [];

        foreach ($fillables as $fillable) {
            $values[$fillable] = $this->$fillable;
        }

        $sql = $this->isStored()
            ? SqlHelper::buildUpdateSql($primaryKey, $this->table(), $fillables)
            : SqlHelper::buildInsertSql($this->table(), $fillables);

        $pdoStatement = $dbConnection->prepare($sql);

        foreach ($values as $key => $value) {
            $pdoStatement->bindParam($key, $value);
        }

        $pdoStatement->execute($values);
    }

    public function isStored(): bool
    {
        $primaryKey = $this->getPrimaryKey();

        return $this->$primaryKey !== null;
    }

    public function table(): string
    {
        return $this->table;
    }

    public function getFillables(): array
    {
        $primaryKey = $this->getPrimaryKey();
        $modelFields = $this->getModelFields();

        return array_filter(
            $modelFields,
            fn (string $field): bool => $field !== $primaryKey,
        );
    }
}
