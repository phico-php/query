<?php

test('can use count()', function ($dialect, $expected) {

    $query = query()->from('users')->count();
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'SELECT COUNT(*) AS `count` FROM `users`'],
            ['sqlite', 'SELECT COUNT(*) AS "count" FROM "users"'],
            ['pgsql', 'SELECT COUNT(*) AS "count" FROM "users"'],
        ]);
test('can use count() with column name', function ($dialect, $expected) {

    $query = query()->from('users')->count('name');
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'SELECT COUNT(`name`) AS `count` FROM `users`'],
            ['sqlite', 'SELECT COUNT("name") AS "count" FROM "users"'],
            ['pgsql', 'SELECT COUNT("name") AS "count" FROM "users"'],
        ]);
test('can use count() with as', function ($dialect, $expected) {

    $query = query()->from('users')->count('*', 'c');
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'SELECT COUNT(*) AS `c` FROM `users`'],
            ['sqlite', 'SELECT COUNT(*) AS "c" FROM "users"'],
            ['pgsql', 'SELECT COUNT(*) AS "c" FROM "users"'],
        ]);
test('can use count() with other fields', function ($dialect, $expected) {

    $query = query()->from('users')->select('name, email')->count();
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'SELECT COUNT(*) AS `count`, `name`, `email` FROM `users`'],
            ['sqlite', 'SELECT COUNT(*) AS "count", "name", "email" FROM "users"'],
            ['pgsql', 'SELECT COUNT(*) AS "count", "name", "email" FROM "users"'],
        ]);
test('make sure limit() is ignored', function ($dialect, $expected) {

    $query = query()->from('users')->select('name, email')->offset(30)->limit(10)->count();
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'SELECT COUNT(*) AS `count`, `name`, `email` FROM `users`'],
            ['sqlite', 'SELECT COUNT(*) AS "count", "name", "email" FROM "users"'],
            ['pgsql', 'SELECT COUNT(*) AS "count", "name", "email" FROM "users"'],
        ]);
