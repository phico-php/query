<?php

namespace Phico\Query\Conditions;

use LogicException;

class Limit
{
    protected int $limit;
    protected null|int $offset;

    public function __construct(int|string $limit, null|int|string $offset = null)
    {
        if ($limit < 1) {
            throw new LogicException('Limit cannot be less than 1');
        }
        if (!is_null($offset) and $offset < 1) {
            throw new LogicException('Offset cannot be less than 1');
        }
        $this->limit = (int) $limit;
        if (!is_null($offset)) {
            $offset = (int) $offset;
        }
        $this->offset = $offset;
    }

    public function toSql(string $dialect): string
    {
        $sql = "LIMIT {$this->limit}";
        if ($this->offset !== null) {
            $sql .= " OFFSET {$this->offset}";
        }
        return $sql;
    }
}
