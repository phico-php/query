<?php

test('can create group by clause', function ($dialect, $expected) {

    $query = query($dialect)->from('users')->groupBy('name');
    expect($query->toSql())->toBe($expected);

})->with([
            ['sqlite', 'SELECT * FROM users GROUP BY name'],
            // ['mysql', 'SELECT * FROM `users`'],
            // ['pgsql', 'SELECT * FROM "users"']
        ]);
test('can create group by clause with ASC', function ($dialect, $expected) {

    $query = query($dialect)->from('users')->groupBy('name', 'ASC');
    expect($query->toSql())->toBe($expected);

})->with([
            ['sqlite', 'SELECT * FROM users GROUP BY name ASC'],
            // ['mysql', 'SELECT * FROM `users`'],
            // ['pgsql', 'SELECT * FROM "users"']
        ]);
test('can create group by clause with DESC', function ($dialect, $expected) {

    $query = query($dialect)->from('users')->groupBy('name', 'DESC');
    expect($query->toSql())->toBe($expected);

})->with([
            ['sqlite', 'SELECT * FROM users GROUP BY name DESC'],
            // ['mysql', 'SELECT * FROM `users`'],
            // ['pgsql', 'SELECT * FROM "users"']
        ]);

test('can use multiple group by clauses', function ($dialect, $expected) {

    $query = query($dialect)->from('users')->groupBy('name')->groupBy('email', 'desc');
    expect($query->toSql())->toBe($expected);

})->with([
            ['sqlite', 'SELECT * FROM users GROUP BY name, email DESC'],
            // ['mysql', 'SELECT * FROM `users`'],
            // ['pgsql', 'SELECT * FROM "users"']
        ]);
test('can use functions', function ($dialect, $expected) {

    $query = query($dialect)->from('users')->groupBy('rand()');
    expect($query->toSql())->toBe($expected);

})->with([
            ['sqlite', 'SELECT * FROM users GROUP BY rand()'],
            // ['mysql', 'SELECT * FROM `users`'],
            // ['pgsql', 'SELECT * FROM "users"']
        ]);
