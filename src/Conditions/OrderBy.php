<?php

namespace Phico\Query\Conditions;

use Phico\Query\Quote;


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
        $out = (str_contains($this->column, '(') and str_contains($this->column, ')'))
            ? sprintf('%s %s', $this->column, $this->dir)
            : sprintf('%s %s', Quote::column($this->column, $dialect), $this->dir);

        return trim($out);
    }
}
