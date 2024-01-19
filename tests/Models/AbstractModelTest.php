<?php

namespace Tests\Models;

use App\Models\AbstractModel;
use App\Models\Annotations\ModelField;
use PHPUnit\Framework\TestCase;
use stdClass;

class AbstractModelTest extends TestCase
{
    /**
     * @test
     */
    public function createsModelFromDbRecord(): void
    {
        $dbRecord = [
            'id' => 101,
            'value' => 'Hello World!',
        ];

        $modelClass = static::getModelClass();

        $model = $modelClass::fromDbRecord($dbRecord);

        $this->assertEquals($dbRecord['id'], $model->id);
        $this->assertEquals($dbRecord['value'], $model->value);
    }

    /**
     * @test
     */
    public function returnsModelFields(): void
    {
        $modelClass = static::getModelClass();

        $modelFields = $modelClass::getModelFields();

        $this->assertTrue(in_array('id', $modelFields));
        $this->assertTrue(in_array('value', $modelFields));
        $this->assertTrue(!in_array('otherProperty', $modelFields));
    }

    /**
     * @test
     */
    public function returnsPrimaryKeyField(): void
    {
        $modelClass = static::getModelClass();

        $this->assertEquals('id', $modelClass::getPrimaryKey());
    }

    /**
     * @return class-string
     */
    protected static function getModelClass(): string
    {
        $model = new class () extends AbstractModel {
            #[ModelField(isPrimary: true)]
            public ?int $id = null;
            #[ModelField]
            public ?string $value = null;
            public ?string $otherProperty = null;
        };

        return $model::class;
    }
}
