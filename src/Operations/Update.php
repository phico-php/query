<?php

namespace Phico\Query\Operations;

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
    public function toSql(string $table)
    {
        return sprintf("UPDATE {$table} SET %s", join(', ', array_map(function ($k) {
            return sprintf('%s = ?', $k);
        }, array_keys($this->data))));
    }
}
