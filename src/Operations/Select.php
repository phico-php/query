<?php

namespace Phico\Query\Operations;

use Phico\Query\Quote;

class Select
{
    protected array $columns;
    protected string $avg = '';
    protected string $count = '';
    protected string $distinct = '';
    protected string $max = '';
    protected string $min = '';
    protected string $sum = '';


    public function __construct(array|string $columns = '')
    {
        $this->columns = is_string($columns) ? array_filter(explode(', ', $columns)) : $columns;
    }
    public function getParams(): array
    {
        return [];
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
    public function toSql(string $table, string $dialect)
    {
        if ($this->distinct) {
            return sprintf(
                "SELECT DISTINCT %s FROM %s",
                Quote::columns($this->columns, $dialect),
                Quote::table($table, $dialect)
            );
        }
        if ($this->avg or $this->count or $this->max or $this->min or $this->sum) {
            if (empty($this->columns)) {
                return sprintf(
                    "SELECT %s%s%s%s%s FROM %s",
                    Quote::aggregate($this->avg, $dialect),
                    Quote::aggregate($this->count, $dialect),
                    Quote::aggregate($this->max, $dialect),
                    Quote::aggregate($this->min, $dialect),
                    Quote::aggregate($this->sum, $dialect),
                    Quote::table($table, $dialect)
                );
            }
            return sprintf(
                "SELECT %s%s%s%s%s, %s FROM %s",
                Quote::aggregate($this->avg, $dialect),
                Quote::aggregate($this->count, $dialect),
                Quote::aggregate($this->max, $dialect),
                Quote::aggregate($this->min, $dialect),
                Quote::aggregate($this->sum, $dialect),
                Quote::columns($this->columns, $dialect),
                Quote::table($table, $dialect)
            );
        }

        return sprintf(
            "SELECT %s FROM %s",
            Quote::columns($this->columns, $dialect),
            Quote::table($table, $dialect)
        );
    }
}
