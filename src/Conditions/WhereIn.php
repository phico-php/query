<?php

namespace Phico\Query\Conditions;

use Phico\Query\Placeholders;
use Phico\Query\Quote;

class WhereIn extends Where
{
    protected array $values;


    public function __construct($column, $values = [], $type = 'AND', $negate = false)
    {
        if (is_callable($column)) {
            $this->query = $column;
        } else {
            $this->column = $column;
        }
        $this->values = $values;
        $this->type = $type;
        $this->negate = $negate;
    }

    public function toSql(string $dialect): string
    {
        if (isset($this->query)) {
            return $this->query->toSql($dialect);
        }

        return sprintf(
            "%s %sIN (%s)",
            ($this->negate) ? 'NOT ' : '',
            Quote::column($dialect, $this->column),
            Placeholders::repeat(count($this->values))
        );
    }
}
