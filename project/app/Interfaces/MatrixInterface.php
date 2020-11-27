<?php declare(strict_types=1);

namespace App\Interfaces;

use App\Classes\ValidMatrix;

interface MatrixInterface
{
    public function __construct(ValidMatrix $matrix);

    public function row(int $row_index): array;

    public function columns(): array;

    public function column(int $column_index): array;

    public function update(ValidMatrix $matrix): MatrixInterface;

    public function toArray(): array;

    public function rowCount(): int;

    public function columnCount(): int;
}
