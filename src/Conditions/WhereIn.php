<?php

namespace Phico\Query\Conditions;

use Phico\Query\Placeholders;
use Phico\Query\Quote;

class WhereIn extends Where
{
    protected array $values;


    public function __construct(string $column, callable|array $values = [], $type = 'AND', $negate = false)
    {
        $this->column = $column;
        if (is_callable($values)) {
            $this->query = query();
            $values($this->query);
        } else {
            $this->values = $values;
        }
        $this->type = $type;
        $this->negate = $negate;
    }
    public function getParams(): array
    {
        if (isset($this->query)) {
            return $this->query->getParams();
        }

        return $this->values;
    }
    public function toSql(string $dialect): string
    {
        if (isset($this->query)) {
            return sprintf(
                "%s%s IN (%s)",
                ($this->negate) ? 'NOT ' : '',
                Quote::column($this->column, $dialect),
                $this->query->toSql($dialect),
            );
        }

        return sprintf(
            "%s%s IN (%s)",
            ($this->negate) ? 'NOT ' : '',
            Quote::column($this->column, $dialect),
            Placeholders::repeat(count($this->values))
        );
    }
}
