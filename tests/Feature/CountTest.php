<?php

test('can use count()', function ($dialect, $expected) {

    $query = query($dialect)->from('users')->count();
    expect($query->toSql())->toBe($expected);

})->with([
            ['sqlite', 'SELECT COUNT(*) AS count FROM users'],
            // ['mysql', 'SELECT * FROM `users`'],
            // ['pgsql', 'SELECT * FROM "users"']
        ]);
test('can use count() with column name', function ($dialect, $expected) {

    $query = query($dialect)->from('users')->count('name');
    expect($query->toSql())->toBe($expected);

})->with([
            ['sqlite', 'SELECT COUNT(name) AS count FROM users'],
            // ['mysql', 'SELECT * FROM `users`'],
            // ['pgsql', 'SELECT * FROM "users"']
        ]);
test('can use count() with as', function ($dialect, $expected) {

    $query = query($dialect)->from('users')->count('*', 'c');
    expect($query->toSql())->toBe($expected);

})->with([
            ['sqlite', 'SELECT COUNT(*) AS c FROM users'],
            // ['mysql', 'SELECT * FROM `users`'],
            // ['pgsql', 'SELECT * FROM "users"']
        ]);
test('can use count() with other fields', function ($dialect, $expected) {

    $query = query($dialect)->from('users')->select('name, email')->count();
    expect($query->toSql())->toBe($expected);

})->with([
            ['sqlite', 'SELECT COUNT(*) AS count, name, email FROM users'],
            // ['mysql', 'SELECT * FROM `users`'],
            // ['pgsql', 'SELECT * FROM "users"']
        ]);
