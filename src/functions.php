<?php

if (!function_exists('query')) {
    function query(string $dialect = ''): \Phico\Query\Query
    {
        return new \Phico\Query\Query($dialect);
    }
}
