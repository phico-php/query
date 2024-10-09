<?php

namespace Phico\Query;

use LogicException;
use Phico\Query\Conditions\{Having, Join, Limit, GroupBy, OrderBy, Where, WhereBetween, WhereIn, WhereNull};
use Phico\Query\Functions\{JsonExtract};
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


    public function __construct(null|string $table = null)
    {
        // default operation is always select;
        $this->operation = new Select();
        // set table name if specified
        if (!is_null($table)) {
            $this->from = $table;
        }
    }
    public function getParams()
    {
        return $this->params;
    }
    public function getLimit(): ?Limit
    {
        return $this->limit;
    }

    public function jsonExtract(string $key, string $as = ''): JsonExtract
    {
        return new JsonExtract($key, $as);
    }

    public function select($columns = '*'): self
    {
        // @TODO if this is set then add columns instead of replacing select
        $this->operation = new Select($columns);
        return $this;
    }
    public function insert(array|object $data): self
    {
        $this->operation = new Insert($data);
        return $this;
    }
    public function update(array|object $data): self
    {
        $this->operation = new Update($data);
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

    public function from(string $from): self
    {
        // @TODO handle nested from clauses
        $this->from = $from;
        return $this;
    }
    public function table(string $table): self
    {
        $this->from = $table;
        return $this;
    }

    public function join(string $table, string $from = 'id', string $to = '', string $operator = '=', string $type = ''): self
    {
        $this->join[] = new Join($table, $from, $to, $operator, strtoupper($type));
        return $this;
    }
    public function innerJoin(string $table, string $from = 'id', string $to = '', string $operator = '='): self
    {
        return $this->join($table, $from, $to, $operator, 'INNER');
    }
    public function outerJoin(string $table, string $from = 'id', string $to = '', string $operator = '='): self
    {
        return $this->join($table, $from, $to, $operator, 'OUTER');
    }
    public function leftJoin(string $table, string $from = 'id', string $to = '', string $operator = '='): self
    {
        return $this->join($table, $from, $to, $operator, 'LEFT');
    }
    public function rightJoin(string $table, string $from = 'id', string $to = '', string $operator = '='): self
    {
        return $this->join($table, $from, $to, $operator, 'RIGHT');
    }
    public function fullJoin(string $table, string $from = 'id', string $to = '', string $operator = '='): self
    {
        return $this->join($table, $from, $to, $operator, 'FULL');
    }
    public function selfJoin(string $table, string $from = 'id', string $to = '', string $operator = '='): self
    {
        return $this->join($table, $from, $to, $operator, 'SELF');
    }
    public function crossJoin(string $table, string $from = 'id', string $to = '', string $operator = '='): self
    {
        return $this->join($table, $from, $to, $operator, 'CROSS');
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

    public function where(callable|string $column, string $operator = '=', mixed $value = null, string $type = 'AND', bool $negate = false)
    {
        $this->where[] = new Where($column, $operator, $value, $type, $negate);
        return $this;
    }
    public function orWhere(callable|string $column, string $operator = '=', mixed $value = null)
    {
        return $this->where($column, $operator, $value, 'OR', false);
    }
    public function whereNot(callable|string $column, string $operator = '=', mixed $value = null)
    {
        return $this->where($column, $operator, $value, 'AND', true);
    }
    public function orWhereNot(callable|string $column, string $operator = '=', mixed $value = null)
    {
        return $this->where($column, $operator, $value, 'OR', true);
    }

    public function whereBetween($column, $min, $max, $type = 'AND', bool $negate = false)
    {
        $this->where[] = new WhereBetween($column, $min, $max, $type, $negate);
        return $this;
    }
    public function orWhereBetween($column, $min, $max)
    {
        return $this->whereBetween($column, $min, $max, 'OR', false);
    }
    public function whereNotBetween($column, $min, $max)
    {
        return $this->whereBetween($column, $min, $max, 'AND', true);
    }
    public function orWhereNotBetween($column, $min, $max)
    {
        return $this->whereBetween($column, $min, $max, 'OR', true);
    }

    public function whereIn($column, $values = null, $type = 'AND', $negate = false)
    {
        $this->where[] = new WhereIn($column, $values, $type, $negate);
        return $this;
    }
    public function orWhereIn($column, $values = null)
    {
        return $this->whereIn($column, $values, 'OR');
    }
    public function whereNotIn($column, $values = null)
    {
        return $this->whereIn($column, $values, 'AND', true);
    }
    public function orWhereNotIn($column, $values = null)
    {
        return $this->whereIn($column, $values, 'OR', true);
    }

    public function whereNull(callable|string $column, mixed $value = null, string $type = 'AND', bool $negate = false)
    {
        $this->where[] = new WhereNull($column, $value, $type, $negate);
        return $this;
    }
    public function orWhereNull(callable|string $column, mixed $value = null)
    {
        return $this->whereNull($column, $value, 'OR', false);
    }
    public function whereNotNull(callable|string $column, mixed $value = null)
    {
        return $this->whereNull($column, $value, 'AND', true);
    }
    public function orWhereNotNull(callable|string $column, mixed $value = null)
    {
        return $this->whereNull($column, $value, 'OR', true);
    }

    public function having(string $column, string $operator = '=', mixed $value = null, string $type = 'AND')
    {
        $this->having[] = new Having($column, $operator, $value, $type);
        return $this;
    }
    public function orHaving(string $column, string $operator = '=', mixed $value = null)
    {
        return $this->having($column, $operator, $value, 'OR');
    }

    public function toSql(string $dialect = 'sqlite')
    {
        $sql = '';

        // from may not be set if this is a nested query, we might only want the where clauses
        if (isset($this->from)) {
            $sql .= $this->operation->toSql($this->from, $dialect);
            $this->params = array_merge($this->params, $this->operation->getParams());
        }

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
                if ($where->isNested()) {
                    // trim if sql begins with where
                    $str = $where->toSql($dialect);
                    $this->params = array_merge($this->params, $where->getParams());
                    if (str_starts_with($str, ' WHERE')) {
                        $str = substr($where->toSql($dialect), 7);
                    }
                    $sql .= ' (' . $str . ')';
                } else {
                    $sql .= ' ' . $where->toSql($dialect);
                    $this->params = array_merge($this->params, $where->getParams());
                }
            }
        }

        if (!empty($this->groupby)) {
            $sql .= ' GROUP BY ';
            $sql .= join(', ', array_map(function ($group) use ($dialect) {
                return $group->toSql($dialect);
            }, $this->groupby));
        }

        if (!empty($this->having)) {
            $sql .= ' HAVING';
            foreach ($this->having as $index => $having) {
                if ($index > 0) {
                    $sql .= ' ' . $having->getType();
                }
                $sql .= ' ' . $having->toSql($dialect);
                $this->params = array_merge($this->params, $having->getParams());
            }
        }

        if (!empty($this->orderby)) {
            $sql .= ' ORDER BY ';
            $sql .= join(', ', array_map(function ($order) use ($dialect) {
                return $order->toSql($dialect);
            }, $this->orderby));
        }

        if (isset($this->limit)) {
            $sql .= ' ' . $this->limit->toSql($dialect);
        }

        return $sql;
    }
}
