<?php

declare(strict_types=1);

namespace Phico\Query;

use Phico\Query\Functions\JsonExtract;


class Quote
{
    public static function table(string $table, string $dialect): string
    {
        return match ($dialect) {
            'mysql', 'mariadb' => "`$table`",
            'pgsql', 'sqlite', 'sqlite2' => '"' . $table . '"',
        };
    }
    public static function column(string|object $column, string $dialect): string
    {
        if ($column instanceof JsonExtract) {
            return $column->toSql($dialect);
        }

        if (empty($column) or $column === '*') {
            return '*';
        }

        return match ($dialect) {
            'mysql', 'mariadb' => str_replace('.', '`.`', "`$column`"),
            'pgsql', 'sqlite', 'sqlite2' => str_replace('.', '"."', '"' . $column . '"'),
        };
    }
    public static function columns(array $columns, string $dialect): string
    {
        if (empty($columns) or $columns === ['*']) {
            return '*';
        }

        $columns = array_map(function ($k) use ($dialect) {
            return Quote::column($k, $dialect);
        }, $columns);

        return (join(', ', $columns));
    }
    public static function aggregate(string $str, string $dialect): string
    {
        $pattern = '/(\b\w+\b|\b\w+\.\w+\b)(?=\s*\))|(?<=AS\s)(\b\w+\b)/';

        $quote = function ($matches) use ($dialect) {
            return match ($dialect) {
                'mysql', 'mariadb' => '`' . $matches[0] . '`',
                'pgsql', 'sqlite', 'sqlite2' => '"' . $matches[0] . '"',
            };
        };

        // Perform the replacement using preg_replace_callback
        return preg_replace_callback($pattern, $quote, $str);
    }
}
