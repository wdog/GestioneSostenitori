<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use RectorLaravel\Set\LaravelSetList;
use RectorLaravel\Set\LaravelSetProvider;

return RectorConfig::configure()
    ->withSetProviders(LaravelSetProvider::class)
    ->withPaths([
        __DIR__ . '/app',
        // __DIR__ . '/bootstrap',
        __DIR__ . '/config',
        // __DIR__ . '/public',
        __DIR__ . '/resources',
        // __DIR__ . '/routes',
        __DIR__ . '/tests',
    ])
    // uncomment to reach your current PHP version
    ->withPhpSets()
    ->withSets([
        LaravelSetList::LARAVEL_CODE_QUALITY,
        LaravelSetList::LARAVEL_COLLECTION,
    ]);
// ->withTypeCoverageLevel(0)
// ->withDeadCodeLevel(0)
// ->withCodeQualityLevel(0)
