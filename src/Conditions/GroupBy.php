<?php

namespace Phico\Query\Conditions;

use Phico\Query\Quote;


class GroupBy
{
    protected string $column;
    protected string $dir;


    public function __construct(string $column)
    {
        $this->column = $column;
    }
    public function toSql(string $dialect): string
    {
        return Quote::column($this->column, $dialect);
    }
}
