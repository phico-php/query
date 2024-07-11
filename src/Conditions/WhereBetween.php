<?php

namespace Phico\Query\Conditions;

use Phico\Query\Placeholders;
use Phico\Query\Quote;

class WhereBetween extends Where
{
    protected int|string $min;
    protected int|string $max;


    public function __construct(callable|string $column, mixed $min, mixed $max, string $type = 'AND', bool $negate = false)
    {
        if (is_callable($column)) {
            $this->query = $column;
        } else {
            $this->column = $column;
        }
        $this->min = $min;
        $this->max = $max;
        $this->type = $type;
        $this->negate = $negate;
    }

    public function toSql(string $dialect): string
    {
        if (isset($this->query)) {
            return $this->query->toSql($dialect);
        }

        return sprintf(
            "%s %sBETWEEN ? AND ?",
            ($this->negate) ? 'NOT ' : '',
            Quote::column($dialect, $this->column),
        );
    }
}
