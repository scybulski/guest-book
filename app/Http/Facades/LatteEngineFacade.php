<?php

namespace App\Http\Facades;

use Latte\Engine as LatteEngine;

final class LatteEngineFacade
{
    protected LatteEngine $latte;

    public const TEMPLATE_DIRECTORY = 'views';

    public const TEMPORARY_DIRECTORY = 'tmp/latte';

    public function __construct(
        LatteEngine $engine = null,
    ) {
        $this->latte = $engine ?? new LatteEngine();

        $this->setUp();
    }

    private function setUp(): void
    {
        $this->latte->setTempDirectory(static::TEMPORARY_DIRECTORY);
    }

    public function render(string $template, array $params = []): void
    {
        $this->latte->render(static::TEMPLATE_DIRECTORY . '/' . $template, $params);
    }
}
