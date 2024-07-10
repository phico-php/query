<?php

class Query
{
    protected array $group_by;
    protected array $select;
    protected string $table;


    public function __construct(?string $table = null)
    {
        if (is_string($table)) {
            $this->table = $table;
        }
    }

    public function from(string $str): self
    {
        $this->from = $str;
        return $this;
    }
    public function groupBy(array|string $columns): self
    {
        if (is_string($columns)) {
            $columns = explode(',', $columns);
        }

        $this->group_by = $columns;

        return $this;
    }


    public function delete(): self
    {
        $this->type = 'delete';
    }
    public function insert(): self
    {
        $this->type = 'insert';
    }
    public function select(array|string $columns): self
    {
        $this->type = 'select';

        if (is_string($columns)) {
            $columns = explode(',', $columns);
        }

        $this->select = $columns;

        return $this;
    }
    public function update(): self
    {
        $this->type = 'update';
    }


    public function having(string $ref, mixed $value, string $operator = '='): self
    {
        $this->having[] = new Having($ref, $operator, $negate);
        return $this;
    }
    public function notHaving(string $ref, mixed $value, string $operator = '='): self
    {
        $this->having[] = new Having($ref, $operator, $negate, 'AND NOT');
        return $this;
    }
    public function orHaving(string $ref, mixed $value, string $operator = '='): self
    {
        $this->having[] = new Having($ref, $operator, $negate, 'OR');
        return $this;
    }
    public function orNotHaving(string $ref, mixed $value, string $operator = '='): self
    {
        $this->having[] = new Having($ref, $operator, $negate, 'OR NOT');
        return $this;
    }

    /**
     * Examples:
     *  where('column', 'value') // where column = value
     *  where('column', '!=', 'value') // where column = value
     *
     * @param string $ref
     * @param string $logic
     * @param string $operator
     * @return self
     */
    public function where(string $ref, mixed $value, string $operator = '='): self
    {
        $this->where[] = new Where($ref, $value, $operator);
        return $this;
    }
    public function whereNot(string $ref, mixed $value, string $operator = '='): self
    {
        $this->where[] = new Where($ref, $value, $operator, 'AND');
        return $this;
    }
    public function orWhere(string $ref, mixed $value, string $operator = '='): self
    {
        $this->where[] = new Where($ref, $value, $operator, 'OR');
        return $this;
    }
    public function orWhereNot(string $ref, mixed $value, string $operator = '='): self
    {
        $this->where[] = new Where($ref, $value, $operator, 'OR NOT');
        return $this;
    }

    public function toString(): string
    {

    }
}

class Having extends NestableClause
{
    public function __construct(string $ref, mixed $value, mixed $operator, string $logic = 'AND')
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
class Join extends NestableClause
{
    protected array $types = ['INNER', 'OUTER', 'LEFT', 'RIGHT', 'FULL', 'SELF', 'CROSS'];

    public function __construct(string $ref, string $from, string $to, string $operator = '=', string $type = '')
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
class Where extends NestableClause
{
    public function __construct(string $ref, mixed $value, string $operator = '=', string $logic = 'AND', string $type = '')
    {
        $this->ref = $ref;
        $this->type = $type;
        $this->logic = $logic;
        $this->operator = $operator;
    }

    public function render(): string
    {

    }
}

class Select extends NestableClause
{
}
class GroupBy extends Clause
{
}
class OrderBy extends Clause
{
}



abstract class Clause
{
    protected array $params;

    public function __construct(array|string $refs)
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
abstract class NestableClause extends Clause
{
    public function __construct(array|string|Closure $refs)
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

$query = new Query;
$query->from('users')->select('id,name as full_name');
$query->where('name', 'like', 'kermit');

echo $query->toString();
