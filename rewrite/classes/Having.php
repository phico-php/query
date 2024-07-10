<?php

class Having extends NestableClause
{
    public function __construct(string $ref, mixed $value, mixed $operator, string $logic='AND')
    {
        $this->ref = $ref;
        $this->value = $value;
        $this->operator = $operator;
        $this->logic = $logic;
    }

    public function render(): string
    {

    }
}
