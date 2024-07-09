<?php

namespace Phico\Query\Operations;

class Truncate
{
    public function toSql(string $table)
    {
        return "TRUNCATE {$table}";
    }
}
