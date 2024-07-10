<?php

namespace Phico\Query\Operations;

use Phico\Query\Quote;

class Truncate
{
    public function toSql(string $table, string $dialect)
    {
        return sprintf('TRUNCATE %s', Quote::table($table, $dialect));
    }
}
