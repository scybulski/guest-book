<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->notPath('bootstrap/cache')
    ->notName('_ide_helper*.php')
    ->ignoreVCS(true);

return (new PhpCsFixer\Config())
        ->setFinder($finder);
