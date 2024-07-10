<?php

declare(strict_types=1);

namespace Phico\Query;


class Quote
{
    public static function column(string $column, string $dialect = 'sqlite'): string
    {
        return match ($dialect) {
            'mysql', 'mariadb' => "`$column`",
            'pgsql', 'sqlite', 'sqlite2' => '"' . $column . '"',
        };
    }
}
