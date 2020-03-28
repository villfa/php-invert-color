#!/usr/bin/env php
<?php

declare(strict_types=1);

use InvertColor\Color;

require_once __DIR__ . '/../vendor/autoload.php';

// triggers autoloading
if (!class_exists(Color::class, true)) {
    printf('Class %s not found%s', Color::class, PHP_EOL);
    return 1;
}

$rgbGenerator = function (): Generator {
    for ($r = 0; $r < 256; $r++) {
        for ($g = 0; $g < 256; $g++) {
            for ($b = 0; $b < 256; $b++) {
                yield [$r, $g, $b];
            }
        }
    }
};

$startTime = microtime(true);

foreach ($rgbGenerator() as $rgb) {
    $hex = Color::fromRGB($rgb)->invert();
    Color::fromHex($hex)->invertAsObj()->invertAsRGB();
}

$timeSpent = microtime(true) - $startTime;

printf('Time spent: %.2fs%s', $timeSpent, PHP_EOL);
printf('Memory peak usage: %d bytes%s', memory_get_peak_usage(true), PHP_EOL);
return 0;
