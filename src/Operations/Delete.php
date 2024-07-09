<?php

namespace Phico\Query\Operations;

class Delete
{
    public function toSql(string $table)
    {
        return "DELETE FROM {$table}";
    }
}
