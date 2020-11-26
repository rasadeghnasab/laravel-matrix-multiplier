<?php

namespace App\Interfaces;

interface MatrixInterface
{
    public function row(int $row_index): array;

    public function columns(): array;

    public function column(int $column_index): array;

    public function toArray(): array;
}
