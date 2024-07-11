<?php

if (!function_exists('query')) {
    function query(string $table = null): \Phico\Query\Query
    {
        return new \Phico\Query\Query($table);
    }
}
