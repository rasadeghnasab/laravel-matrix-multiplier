<?php declare(strict_types=1);

namespace App\Interfaces;

interface MatrixTransformerInterface
{
    public static function transform(MatrixInterface $matrix): array;
}
