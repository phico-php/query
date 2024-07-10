<?php


class Join extends NestableClause
{
    protected array $types = ['INNER','OUTER','LEFT','RIGHT','FULL','SELF','CROSS'];

    public function __construct(string $ref, string $from, string $to, string $operator='=', string $type='')
    {
        $this->ref = $ref;
        $this->from = $from;
        $this->to = $to;
        $this->operator = $operator;
        $this->type = $type;
    }

    public function render(): string
    {

    }
}
