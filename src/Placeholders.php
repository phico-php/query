<?php

declare(strict_types=1);

namespace Phico\Query;


class Placeholders
{
    public static function repeat(int $count): string
    {
        return join(', ', array_fill(0, $count, '?'));
    }
}
