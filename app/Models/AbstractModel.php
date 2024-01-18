<?php

namespace App\Models;

use App\Models\Annotations\ModelField;
use ReflectionClass;
use ReflectionProperty;
use stdClass;

abstract class AbstractModel
{
    public final function __construct()
    {
    }

    public static function fromDbRecord(stdClass $dbRecord): static {
        $model = new static();

        $fields = static::getModelFields();

        array_walk(
            $fields,
            function (string $field) use ($dbRecord, $model): void {
                $model->$field = $dbRecord->$field;
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
}
