<?php

namespace Phico\Query\Conditions;

use Phico\Query\Quote;


class WhereBetween extends Where
{
    protected int|string $min;
    protected int|string $max;


    public function __construct(callable|string $column, mixed $min, mixed $max, string $type = 'AND', bool $negate = false)
    {
        if (is_callable($column)) {
            $this->query = query();
            $column($this->query);
        } else {
            $this->column = $column;
        }
        $this->min = $min;
        $this->max = $max;
        $this->type = $type;
        $this->negate = $negate;
    }
    public function getParams(): array
    {
        if (isset($this->query)) {
            return $this->query->getParams();
        }

        return [$this->min, $this->max];
    }
    public function toSql(string $dialect): string
    {
        if (isset($this->query)) {
            return $this->query->toSql($dialect);
        }

        return sprintf(
            "%s%s BETWEEN ? AND ?",
            ($this->negate) ? 'NOT ' : '',
            Quote::column($this->column, $dialect),
        );
    }
}
