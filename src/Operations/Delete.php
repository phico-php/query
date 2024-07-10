<?php

namespace Phico\Query\Operations;

use Phico\Query\Quote;

class Delete
{
    public function getParams(): array
    {
        return [];
    }
    public function toSql(string $table, string $dialect)
    {
        return sprintf("DELETE FROM %s", Quote::table($table, $dialect));
    }
}
