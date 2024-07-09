<?php

namespace Phico\Query\Conditions;

class Where
{
    protected $column;
    protected $operator;
    protected $value;
    protected $type;


    public function __construct($column, $operator, $value, $type = 'AND')
    {
        $this->column = $column;
        $this->operator = $operator;
        $this->value = $value;
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function toSql($dialect)
    {
        return "{$this->column} {$this->operator} ?";
    }
}
