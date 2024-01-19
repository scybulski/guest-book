<?php

namespace App\Models\Annotations;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class ModelField
{
    public function __construct(
        public readonly bool $isPrimary = false,
    ) {
    }
}
