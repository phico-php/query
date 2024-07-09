<?php

namespace Phico\Query\Operations;

class Insert
{
    protected array $data;

    // @TODO handle assoc arrays or array of objects etc

    public function __construct(array|object $data = [])
    {
        $this->data = $data;
    }
    public function getParams(): array
    {
        return array_values($this->data);
    }
    public function toSql(string $table)
    {
        return sprintf("INSERT INTO {$table} (%s) VALUES (%s)", join(', ', array_keys($this->data)), join(', ', array_fill(0, count($this->data), '?')));
    }
}
