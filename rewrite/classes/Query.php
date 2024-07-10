<?php

class Query
{
    // the group by clauses
    protected GroupBy $group_by;
    // the order by clauses
    protected OrderBy $order_by;
    // the select clause
    protected Select $select;
    // the from clause
    protected From $from;
    // the query type, used during rendering
    protected string $type;


    public function __construct(string $from = '')
    {
        if (!empty($from)) {
            $this->from($from);
        }

        $this->group_by = new GroupBy();
        $this->order_by = new OrderBy();
        $this->select = new Select();
    }
    public function from(string|Closure $ref): self
    {
        $this->from = new From($ref);
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
    public function where(string $ref, mixed $value, mixed $operator = null): self
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
        if (!empty($this->where)) {
            $use_logic = false;
            $where = 'where';
            foreach ($this->where as $clause) {
                $where .= $clause->render($use_logic);
                $use_logic = true;
            }
        }

        return match ($this->type) {
            'select' => sprintf('select %s from %s %s', join(',', $this->select), $this->from, $where),
            'delete' => sprintf('delete from %s %s', $this->from, $where),
        };
    }
}


