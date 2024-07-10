<?php

abstract class Clause
{
    protected array $params;

    public function add(array|string $refs)
    {
        if (is_string($refs)) {
            $refs = explode(',', $refs);
        }

        $this->params = $refs;
    }
    public function render(): string
    {
        return join(',', array_values($this->params));
    }
}
