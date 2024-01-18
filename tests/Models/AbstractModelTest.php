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
        $dbRecord = new stdClass();
        $dbRecord->id = 101;
        $dbRecord->value = 'Hello World!';

        $modelClass = static::getModelClass();

        $model = $modelClass::fromDbRecord($dbRecord);

        $this->assertEquals($dbRecord->id, $model->id);
        $this->assertEquals($dbRecord->value, $model->value);
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
     * @return class-string
     */
    protected static function getModelClass(): string {
        $model = new class () extends AbstractModel {
            #[ModelField]
            public ?int $id = null;
            #[ModelField]
            public ?string $value = null;
            public ?string $otherProperty = null;
        };

        return $model::class;
    }
}
