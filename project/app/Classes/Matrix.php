<?php

namespace App\Classes;

use App\Exceptions\EmptyMatrixException;
use App\Interfaces\MatrixInterface;
use Exception;

class Matrix implements MatrixInterface
{
    /**
     * @var array
     */
    private array $matrix;
    private array $columns = [];

    /**
     * Matrix constructor.
     * @param array $matrix
     * @throws EmptyMatrixException
     */
    public function __construct(array $matrix)
    {
        $this->checkMatrix($matrix);

        $this->matrix = $matrix;
    }

    /**
     * Returns matrix columns
     *
     * @return array
     */
    public function columns(): array
    {
        if (!empty($this->columns)) {
            return $this->columns;
        }

        $columns = [];
        foreach ($this->matrix as $row_index => $row) {
            foreach ($row as $column_index => $item) {
                $columns[$column_index][$row_index] = $item;
            }
        }

        return $this->columns = $columns;
    }

    /**
     * Returns a specific row from the matrix
     *
     * @param int $row_index
     * @return array
     * @throws Exception
     */
    public function row(int $row_index): array
    {
        if (!isset($this->matrix[$row_index])) {
            throw new Exception(sprintf('The matrix has exactly %d rows.', count($this->matrix)));
        }
        return $this->matrix[$row_index];
    }

    /**
     * Returns a specific column from the matrix
     *
     * @param int $column_index
     * @return array
     * @throws Exception
     */
    public function column(int $column_index): array
    {
        $columns = $this->columns();

        if (!isset($columns[$column_index])) {
            throw new Exception(sprintf('The matrix has exactly %d columns.', count($this->columns)));
        }

        return $columns[$column_index];
    }

    /**
     * A matrix can be updated by new values
     * @param array $matrix
     * @return $this
     * @throws EmptyMatrixException
     */
    public function update(array $matrix): self
    {
        $this->checkMatrix($matrix);

        $this->matrix = $matrix;

        return $this;
    }

    public function rowCount(): int
    {
        return count($this->matrix);
    }

    public function columnCount(): int
    {
        return count($this->matrix[0]);
    }

    /**
     * Returns matrix as an array
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->matrix;
    }

    private function checkMatrix($matrix)
    {
        if (empty($matrix)) throw new EmptyMatrixException('Matrix can not be empty');
    }
}
