<?php

namespace Phico\Query\Operations;

abstract class Operation
{
    /**
     * Returns a list of parameter values
     * @return array<int,mixed>
     */
    public function getParams(): array
    {
        return [];
    }
}
