<?php

test('can create group by clause', function ($dialect, $expected) {

    $query = query()->from('users')->groupBy('name');
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'SELECT * FROM `users` GROUP BY `name`'],
            ['pgsql', 'SELECT * FROM "users" GROUP BY "name"'],
            ['sqlite', 'SELECT * FROM "users" GROUP BY "name"'],
        ]);
test('can use multiple group by clauses', function ($dialect, $expected) {

    $query = query()->from('users')->groupBy('name')->groupBy('email');
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'SELECT * FROM `users` GROUP BY `name`, `email`'],
            ['pgsql', 'SELECT * FROM "users" GROUP BY "name", "email"'],
            ['sqlite', 'SELECT * FROM "users" GROUP BY "name", "email"'],
        ]);
