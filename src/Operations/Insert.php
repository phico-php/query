<?php

namespace Phico\Query\Operations;

use InvalidArgumentException;
use Phico\Query\Placeholders;
use Phico\Query\Quote;

class Insert
{
    protected array $data;

    // @TODO handle assoc arrays or array of objects etc

    public function __construct(array|object $data = [])
    {
        if (empty($data)) {
            throw new InvalidArgumentException('Cannot update with an empty data set');
        }

        $this->data = $data;
    }
    public function getParams(): array
    {
        return array_values($this->data);
    }
    public function toSql(string $table, string $dialect)
    {
        $columns = join(', ', array_map(function ($k) use ($dialect) {
            return sprintf('%s', Quote::column($k, $dialect));
        }, array_keys($this->data)));

        return sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            Quote::table($table, $dialect),
            $columns,
            Placeholders::repeat(count($this->data))
        );
    }
}
