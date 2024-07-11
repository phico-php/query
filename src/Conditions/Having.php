<?php

namespace Phico\Query\Conditions;

use Phico\Query\Quote;


class Having
{
    protected string $column;
    protected string $operator;
    protected mixed $value;
    protected string $type;


    public function __construct(string $column, string $operator = '=', mixed $value = null, string $type = 'AND')
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
    public function getType(): string
    {
        return $this->type;
    }
    public function toSql(string $dialect): string
    {
        return sprintf(
            "%s %s ?",
            (str_contains($this->column, '(')) ? Quote::aggregate($this->column, $dialect) : Quote::column($this->column, $dialect),
            $this->operator,
        );
    }
}
