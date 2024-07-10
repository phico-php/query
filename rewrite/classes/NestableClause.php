<?php

abstract class NestableClause extends Clause
{
    public function add(array|string|Closure $refs)
    {
        if ($refs instanceof Closure) {
            $this->params[] = $this->nest($refs);
        } elseif (is_string($refs)) {
            $this->params = explode(',', $refs);
        } else {
            $this->params = $refs;
        }
    }
    protected function nest(Closure $closure): Query
    {
        $query = new Query;

        call_user_func_array($closure, [$query]);

        return $query;
    }
    // render method must handle nested queries and extract params too
    public function render(): string
    {
        return join(',', array_values($this->params));
    }
}
