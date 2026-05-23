<?php

declare(strict_types=1);

$basePath = dirname(__DIR__);

return [
    'app_name' => 'Inventario MVC',
    'paths' => [
        'base' => $basePath,
        'views' => $basePath . '/app/Views',
        'storage' => $basePath . '/storage/data',
    ],
];
