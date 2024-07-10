<?php

namespace Phico\Query\Operations;

use Phico\Query\Quote;

class Update
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
    public function getParams(): array
    {
        return array_values($this->data);
    }
    public function toSql(string $table, string $dialect)
    {
        return sprintf(
            "UPDATE %s SET %s",
            Quote::table($table, $dialect),
            join(', ', array_map(function ($k) use ($dialect) {
                return sprintf('%s = ?', Quote::column($k, $dialect));
            }, array_keys($this->data)))
        );
    }
}
