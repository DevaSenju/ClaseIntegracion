<?php

declare(strict_types=1);

function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function selected(mixed $value, mixed $expected): string
{
    return (string) $value === (string) $expected ? 'selected' : '';
}
