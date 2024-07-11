<?php

namespace Phico\Query\Conditions;

use Phico\Query\Query;
use Phico\Query\Quote;


class Where
{
    protected string $column;
    protected string $operator;
    protected mixed $value;
    protected string $type;
    protected bool $negate;
    protected null|Query $query;


    public function __construct(callable|string $column, string $operator = '=', mixed $value = null, string $type = 'AND', bool $negate = false)
    {
        if (is_callable($column)) {
            $this->query = query();
            $column($this->query);
        } else {
            $this->column = $column;
        }
        $this->operator = $operator;
        $this->value = $value;
        $this->type = $type;
        $this->negate = $negate;
    }
    public function getParams(): array
    {
        if (isset($this->query)) {
            return $this->query->getParams();
        }

        return [$this->value];
    }
    public function getType(): string
    {
        return $this->type;
    }
    public function isNegated(): bool
    {
        return $this->negate;
    }
    public function isNested(): bool
    {
        return isset($this->query);
    }
    public function toSql(string $dialect): string
    {
        if (isset($this->query)) {
            return $this->query->toSql($dialect);
        }

        return sprintf(
            "%s%s %s ?",
            ($this->negate) ? 'NOT ' : '',
            Quote::column($this->column, $dialect),
            $this->operator,
        );
    }
}
