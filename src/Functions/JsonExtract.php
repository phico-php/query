<?php

namespace Phico\Query\Functions;


// provides standard access to nested json fields
class JsonExtract
{
    protected string $path;
    protected string $as;


    public function __construct(string $path, string $as = '')
    {
        $this->path = $path;
        $this->as = $as;
    }
    public function toSql(string $dialect): string
    {
        $sql = match ($dialect) {
            'mysql', 'mariadb' => sprintf("json_extract(%s, '$.%s') %s", $this->fieldname(), $this->path('.'), $this->as()),
            'pgsql' => sprintf("%s->>%s %s", $this->fieldname(), $this->path('->>', "'"), $this->as()),
            'sqlite' => sprintf("json_extract(%s, '$.%s') %s", $this->fieldname(), $this->path('.'), $this->as()),
        };

        return trim($sql);
    }

    protected function fieldname(): string
    {
        $path = explode('.', $this->path);
        return array_shift($path);
    }
    protected function path(string $separator, string $quote = ''): string
    {
        $path = explode('.', $this->path);
        array_shift($path);

        $out = [];
        foreach ($path as $v) {
            $out[] = $quote . $v . $quote;
        }

        return join($out, $separator);
    }
    protected function as(): string
    {
        if (!empty($this->as)) {
            return " AS {$this->as}";
        }
    }
}
