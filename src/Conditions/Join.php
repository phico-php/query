<?php

namespace Phico\Query\Conditions;

use LogicException;
use Phico\Query\Quote;


class Join
{
    protected string $table;
    protected string $from;
    protected string $to;
    protected string $operator;
    protected string $type;


    public function __construct(string $table, string $from = 'id', string $to = '', string $operator = '=', string $type = '')
    {
        if (!empty($type) and !in_array($type, ['INNER', 'OUTER', 'LEFT', 'RIGHT', 'FULL', 'SELF', 'CROSS'])) {
            throw new LogicException(sprintf('Cannot create JOIN clause with unknown type %s', $type));
        }

        $this->table = $table;
        $this->from = $from;
        $this->to = $to;
        $this->operator = $operator;
        $this->type = $type;
    }

    public function toSql(string $table, string $dialect): string
    {
        return trim(
            sprintf(
                "%s JOIN %s ON %s.%s %s %s.%s",
                $this->type,
                Quote::table($this->table, $dialect),
                Quote::table($table, $dialect),
                Quote::column($this->from, $dialect),
                $this->operator,
                Quote::column($this->table, $dialect),
                (empty($this->to)) ? Quote::column("{$table}_id", $dialect) : Quote::column($this->to, $dialect)
            )
        );
    }
}
