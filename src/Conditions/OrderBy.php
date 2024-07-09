<?php

namespace Phico\Query\Conditions;


class OrderBy
{
    protected string $column;
    protected string $dir;


    public function __construct(string $column, string $dir = '')
    {
        $dir = strtoupper($dir);
        $this->dir = in_array($dir, ['ASC', 'DESC']) ? $dir : '';
        $this->column = $column;
    }
    public function toSql(string $dialect): string
    {
        return trim("{$this->column} {$this->dir}");
    }
}
