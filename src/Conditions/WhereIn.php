<?php

namespace Phico\Query\Conditions;

use Phico\Query\Placeholders;
use Phico\Query\Quote;

class Where
{
    protected string $column;
    protected array $values;
    protected string $logic;
    protected bool $negate;


    public function __construct($column, $values = [], $logic = 'AND', $negate = false)
    {
        $this->column = $column;
        $this->values = $values;
        $this->logic = $logic;
        $this->negate = $negate;
    }
    public function getParams(): array
    {
        return $this->values;
    }
    public function getLogic(): string
    {
        return $this->logic;
    }
    public function toSql(string $dialect): string
    {
        return sprintf(
            "%s %sIN (%s)",
            ($this->negate) ? 'NOT ' : '',
            Quote::column($dialect, $this->column),
            Placeholders::repeat(count($this->values))
        );
    }
}
