<?php

class Query
{
    // the group by clauses
    protected array $group_by;
    // the order by clauses
    protected array $order_by;
    // the columns to select
    protected array $select;
    // the table to query
    protected string $from;
    // the query type, used during rendering
    protected string $type;


    public function __construct(string $from='')
    {
        if ( ! empty($from)) {
            $this->from = $from;
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

        $this->group_by[] = $columns;

        return $this;
    }
    public function orderBy(array|string $columns): self
    {
        if (is_string($columns)) {
            $columns = explode(',', $columns);
        }

        $this->order_by[] = $columns;

        return $this;
    }


    public function delete(): self
    {
        $this->type = 'delete';
        return $this;
    }
    public function insert(array $data): self
    {
        $this->type = 'insert';
        return $this;
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
    public function update(array $data): self
    {
        $this->type = 'update';
        return $this;
    }


//     public function having(string $ref, mixed $value, string $operator='='): self
//     {
//         $this->having[] = new Having($ref, $operator);
//         return $this;
//     }
//     public function notHaving(string $ref, mixed $value, string $operator='='): self
//     {
//         $this->having[] = new Having($ref, $operator, 'AND NOT');
//         return $this;
//     }
//     public function orHaving(string $ref, mixed $value, string $operator='='): self
//     {
//         $this->having[] = new Having($ref, $operator, 'OR');
//         return $this;
//     }
//     public function orNotHaving(string $ref, mixed $value, string $operator='='): self
//     {
//         $this->having[] = new Having($ref, $operator, 'OR NOT');
//         return $this;
//     }

    /**
     * Examples:
     *  where('column', 'value') // where column = value
     *  where('column', '!=', 'value') // where column = value
     *
     * @param string $ref
     * @param mixed $value
     * @param mixed $operator
     * @return self
     */
    public function where(string $ref, mixed $value, mixed $operator=null): self
    {
        if (is_null($operator)) {
            $this->where[] = new Where($ref, '=', $value);
        } else {
            $this->where[] = new Where($ref, $value, $operator);
        }
        return $this;
    }
//     public function whereNot(string $ref, mixed $value, string $operator='='): self
//     {
//         $this->where[] = new Where($ref, $operator);
//         return $this;
//     }
//     public function orWhere(string $ref, mixed $value, string $operator='='): self
//     {
//         $this->where[] = new Where($ref, $operator);
//         return $this;
//     }
//     public function orWhereNot(string $ref, mixed $value, string $operator='='): self
//     {
//         $this->where[] = new Where($ref, $operator);
//         return $this;
//     }

    public function toString(): string
    {
        $where = '';
        if ( ! empty($this->where)) {
            $use_logic = false;
            $where = 'where';
            foreach ($this->where as $clause) {
                $where.= $clause->render($use_logic);
                $use_logic = true;
            }
        }

        return match($this->type) {
          'select' => sprintf('select %s from %s %s', join(',', $this->select), $this->from, $where),
          'delete' => sprintf('delete from %s %s', $this->from, $where),
        };
    }
}

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



echo "\n";

$query = new Query;
$query->from('users')->select('id,name as full_name');
$query->where('name', 'like', '%kermit%');
$query->where('species', 'frog');
$query->orderBy('name asc, id desc');
echo $query->toString();

echo "\n";

$query = new Query;
$query->from('users')->delete();
$query->where('name', 'like', 'kermit');
echo $query->toString();

echo "\n";

