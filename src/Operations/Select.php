<?php

namespace Phico\Query\Operations;

class Select
{
    protected string $columns;
    protected string $avg = '';
    protected string $count = '';
    protected string $distinct = '';
    protected string $max = '';
    protected string $min = '';
    protected string $sum = '';


    public function __construct(array|string $columns = '')
    {
        $this->columns = is_array($columns) ? implode(', ', $columns) : $columns;
    }
    public function distinct(): self
    {
        $this->distinct = 'DISTINCT';
        return $this;
    }
    public function count(string $column = '*', string $as = 'count'): self
    {
        $this->count = "COUNT({$column}) AS {$as}";
        return $this;
    }
    public function sum(string $column, string $as = 'sum'): self
    {
        $this->sum = "SUM({$column}) AS {$as}";
        return $this;
    }
    public function avg(string $column, string $as = 'avg'): self
    {
        $this->avg = "AVG({$column}) AS {$as}";
        return $this;
    }
    public function min(string $column, string $as = 'min'): self
    {
        $this->min = "MIN({$column}) AS {$as}";
        return $this;
    }
    public function max(string $column, string $as = 'max'): self
    {
        $this->max = "MAX({$column}) AS {$as}";
        return $this;
    }
    public function toSql(string $table)
    {
        if ($this->distinct) {
            return "SELECT {$this->distinct} {$this->columns} FROM {$table}";
        }
        if ($this->avg or $this->count or $this->max or $this->min or $this->sum) {
            if (empty($this->columns)) {
                return "SELECT {$this->avg}{$this->count}{$this->max}{$this->min}{$this->sum} FROM {$table}";
            }
            return "SELECT {$this->avg}{$this->count}{$this->max}{$this->min}{$this->sum}, {$this->columns} FROM {$table}";
        }

        if (empty($this->columns)) {
            $this->columns = '*';
        }
        return "SELECT {$this->columns} FROM {$table}";
    }
}
