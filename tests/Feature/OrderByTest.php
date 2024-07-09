<?php

test('can create order by clause', function ($dialect, $expected) {

    $query = query($dialect)->from('users')->orderBy('name');
    expect($query->toSql())->toBe($expected);

})->with([
            ['sqlite', 'SELECT * FROM users ORDER BY name'],
            // ['mysql', 'SELECT * FROM `users`'],
            // ['pgsql', 'SELECT * FROM "users"']
        ]);
test('can create order by clause with ASC', function ($dialect, $expected) {

    $query = query($dialect)->from('users')->orderBy('name', 'ASC');
    expect($query->toSql())->toBe($expected);

})->with([
            ['sqlite', 'SELECT * FROM users ORDER BY name ASC'],
            // ['mysql', 'SELECT * FROM `users`'],
            // ['pgsql', 'SELECT * FROM "users"']
        ]);
test('can create order by clause with DESC', function ($dialect, $expected) {

    $query = query($dialect)->from('users')->orderBy('name', 'DESC');
    expect($query->toSql())->toBe($expected);

})->with([
            ['sqlite', 'SELECT * FROM users ORDER BY name DESC'],
            // ['mysql', 'SELECT * FROM `users`'],
            // ['pgsql', 'SELECT * FROM "users"']
        ]);

test('can use multiple order by clauses', function ($dialect, $expected) {

    $query = query($dialect)->from('users')->orderBy('name')->orderBy('email', 'desc');
    expect($query->toSql())->toBe($expected);

})->with([
            ['sqlite', 'SELECT * FROM users ORDER BY name, email DESC'],
            // ['mysql', 'SELECT * FROM `users`'],
            // ['pgsql', 'SELECT * FROM "users"']
        ]);
test('can use functions', function ($dialect, $expected) {

    $query = query($dialect)->from('users')->orderBy('rand()');
    expect($query->toSql())->toBe($expected);

})->with([
            ['sqlite', 'SELECT * FROM users ORDER BY rand()'],
            // ['mysql', 'SELECT * FROM `users`'],
            // ['pgsql', 'SELECT * FROM "users"']
        ]);
