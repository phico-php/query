<?php

class Where extends NestableClause
{
    public function __construct(string $ref, string $operator, mixed $value, ?string $logic='AND', ?string $type='')
    {
        $this->ref = $ref;
        $this->operator = $operator;
        $this->value = $value;
        $this->logic = $logic;
        $this->type = $type;
    }

    public function render(bool $use_logic=false): string
    {
        return ($use_logic)
            ? sprintf(" %s %s %s '%s'", $this->logic, $this->ref, $this->operator, $this->value)
            : sprintf(" %s %s '%s'", $this->ref, $this->operator, $this->value);
    }
}
