<?php

namespace App\Models;

use App\Models\Annotations\ModelField;

class Comment extends AbstractModel
{
    protected string $table = 'comments';

    #[ModelField(true)]
    public ?int $id = null;
    #[ModelField]
    public ?string $name = null;
    #[ModelField]
    public ?string $comment = null;
}
