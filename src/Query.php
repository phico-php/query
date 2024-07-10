<?php

namespace Phico\Query;

use LogicException;
use Phico\Query\Conditions\{Join, Limit, GroupBy, OrderBy, Where};
use Phico\Query\Operations\{Select, Insert, Update, Delete, Truncate};


class Query
{
    protected $operation;
    protected $from;
    protected $limit;
    protected $join = [];
    protected $orderby = [];
    protected $groupby = [];
    protected $where = [];
    protected $having = [];
    protected $params = [];


    public function __construct()
    {
        // default operation is always select;
        $this->operation = new Select();
    }
    public function getParams()
    {
        return $this->operation->getParams();
    }
    public function select($columns = '*'): self
    {
        $this->operation = new Select($columns);
        return $this;
    }
    public function insert($table): self
    {
        $this->operation = new Insert($table);
        return $this;
    }
    public function update($table): self
    {
        $this->operation = new Update($table);
        return $this;
    }
    public function delete(): self
    {
        $this->operation = new Delete();
        return $this;
    }
    public function truncate(): self
    {
        $this->operation = new Truncate();
        return $this;
    }

    public function from($from): self
    {
        $this->from = $from;
        return $this;
    }
    public function table(string $table): self
    {
        $this->from = $table;
        return $this;
    }

    public function join(string $table, string $from = 'id', string $to = '', string $operator = '=', string $type = 'inner'): self
    {
        $this->join[] = new Join($table, $from, $to, $operator, strtoupper($type));

        return $this;
    }

    public function distinct(): self
    {
        if (!$this->operation instanceof Select) {
            throw new LogicException(sprintf('Cannot call %s on a %s query', __METHOD__, get_class($this->operation)));
        }
        $this->operation->distinct();
        return $this;
    }
    public function count(string $column = '*', string $as = 'count'): self
    {
        if (!$this->operation instanceof Select) {
            throw new LogicException(sprintf('Cannot call %s on a %s query', __METHOD__, get_class($this->operation)));
        }
        $this->operation->count($column, $as);
        return $this;
    }
    public function sum(string $column, string $as = 'sum'): self
    {
        if (!$this->operation instanceof Select) {
            throw new LogicException(sprintf('Cannot call %s on a %s query', __METHOD__, get_class($this->operation)));
        }
        $this->operation->sum($column, $as);
        return $this;
    }
    public function avg(string $column, string $as = 'avg'): self
    {
        if (!$this->operation instanceof Select) {
            throw new LogicException(sprintf('Cannot call %s on a %s query', __METHOD__, get_class($this->operation)));
        }
        $this->operation->avg($column, $as);
        return $this;
    }
    public function min(string $column, string $as = 'min'): self
    {
        if (!$this->operation instanceof Select) {
            throw new LogicException(sprintf('Cannot call %s on a %s query', __METHOD__, get_class($this->operation)));
        }
        $this->operation->min($column, $as);
        return $this;
    }
    public function max(string $column, string $as = 'max'): self
    {
        if (!$this->operation instanceof Select) {
            throw new LogicException(sprintf('Cannot call %s on a %s query', __METHOD__, get_class($this->operation)));
        }
        $this->operation->max($column, $as);
        return $this;
    }

    public function limit(int|string $limit, null|int|string $offset = null): self
    {
        $this->limit = new Limit($limit, $offset);
        return $this;
    }

    public function groupBy(array|string $column, string $dir = ''): self
    {
        $this->groupby[] = new GroupBy($column, $dir);

        return $this;
    }
    public function orderBy(array|string $column, string $dir = ''): self
    {
        $this->orderby[] = new OrderBy($column, $dir);

        return $this;
    }

    public function where($column, $operator = null, $value = null, $logic = 'AND')
    {
        if (is_callable($column)) {
            $query = new Query();
            $column($query);
            $this->where[] = $query;
        } else {
            $this->where[] = new Where($column, $operator, $value);
        }
        return $this;
    }
    public function orWhere($column, $operator = null, $value = null)
    {
        return $this->where($column, $operator, $value, 'OR');
    }
    public function whereNot($column, $operator = null, $value = null)
    {
        return $this->where($column, $operator, $value, 'NOT');
    }
    public function orWhereNot($column, $operator = null, $value = null)
    {
        return $this->where($column, $operator, $value, 'OR NOT');
    }
    public function whereBetween($column, $min, $max, $logic = 'AND')
    {
        $this->where[] = new WhereBetween($column, $min, $max);
    }
    public function orWhereBetween($column, $min, $max)
    {
        $this->where($column, $min, $max, 'OR');
    }
    public function whereNotBetween($column, $min, $max)
    {
        $this->where($column, $min, $max, 'NOT');
    }
    public function orWhereNotBetween($column, $min, $max)
    {
        $this->where($column, $min, $max, 'OR NOT');
    }

    public function whereIn($column, $values = null, $logic = 'AND', $negate = false)
    {
        if (is_callable($column)) {
            $query = new Query();
            $column($query);
            $this->where[] = $query;
        } else {
            $this->where[] = new WhereIn($column, $operator, $value);
        }
        return $this;
    }
    public function orWhereIn($column, $operator = null, $value = null)
    {
        return $this->where($column, $operator, $value, 'OR');
    }
    public function whereNotIn($column, $operator = null, $value = null)
    {
        return $this->where($column, $operator, $value, 'NOT');
    }
    public function orWhereNotIn($column, $operator = null, $value = null)
    {
        return $this->where($column, $operator, $value, 'OR NOT');
    }



    public function toSql(string $dialect = 'sqlite')
    {
        $sql = $this->operation->toSql($this->from, $dialect);

        if (!empty($this->join)) {
            foreach ($this->join as $join) {
                $sql .= ' ' . $join->toSql($this->from, $dialect);
            }
        }

        if (!empty($this->where)) {
            $sql .= ' WHERE';
            foreach ($this->where as $index => $where) {
                if ($index > 0) {
                    $sql .= ' ' . $where->getType();
                }
                $sql .= ' ' . $where->toSql($dialect);
                $this->params = array_merge($this->params, array_values($where->getParams()));
            }
        }

        if (isset($this->limit)) {
            $sql .= ' ' . $this->limit->toSql($dialect);
        }

        if (!empty($this->groupby)) {
            $sql .= ' GROUP BY ';
            $sql .= join(', ', array_map(function ($group) use ($dialect) {
                return $group->toSql($dialect);
            }, $this->groupby));
        }

        if (!empty($this->orderby)) {
            $sql .= ' ORDER BY ';
            $sql .= join(', ', array_map(function ($order) use ($dialect) {
                return $order->toSql($dialect);
            }, $this->orderby));
        }

        return $sql;
    }
}
