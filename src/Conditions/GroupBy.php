<?php

namespace Phico\Query\Conditions;


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
        return $this->column;
    }
}
