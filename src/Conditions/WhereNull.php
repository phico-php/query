<?php

namespace Phico\Query\Conditions;

use Phico\Query\{Query, Quote};


class WhereNull extends Where
{
    public function __construct(string $column, callable $callable = null, $type = 'AND', $negate = false)
    {
        $this->column = $column;
        if ($callable instanceof \Closure) {
            $this->query = query();
            $callable($this->query);
        }
        $this->type = $type;
        $this->negate = $negate;
    }
    public function getParams(): array
    {
        return [];
    }
    public function isNested(): bool
    {
        return false;
    }
    public function toSql(string $dialect): string
    {
        if (isset($this->query)) {
            return sprintf(
                "(%s) IS %sNULL",
                $this->query->toSql($dialect),
                ($this->negate) ? 'NOT ' : '',
            );
        }

        return sprintf(
            "%s IS %sNULL",
            Quote::column($this->column, $dialect),
            ($this->negate) ? 'NOT ' : '',
        );
    }
}
