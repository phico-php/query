<?php

namespace Phico\Query\Conditions;

use Phico\Query\Quote;


class Where
{
    protected $column;
    protected $operator;
    protected $value;
    protected $type;


    public function __construct($column, $operator = null, $value = null, $type = 'AND')
    {
        $this->column = $column;
        $this->operator = $operator;
        $this->value = $value;
        $this->type = $type;
    }
    public function getParams(): array
    {
        return [$this->value];
    }
    public function getType()
    {
        return $this->type;
    }
    public function toSql(string $dialect): string
    {
        return sprintf(
            "%s %s ?",
            Quote::column($this->column, $dialect),
            $this->operator,
        );
    }
}
