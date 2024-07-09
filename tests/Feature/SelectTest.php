<?php

test('can create select query', function ($dialect, $expected) {

    $query = query($dialect)->from('users');
    expect($query->toSql())->toBe($expected);

})->with([
            ['sqlite', 'SELECT * FROM users'],
            // ['mysql', 'SELECT * FROM `users`'],
            // ['pgsql', 'SELECT * FROM "users"']
        ]);

test('can create select query with column names from array', function ($dialect, $expected) {

    $query = query($dialect)->from('users')->select('name, email');
    expect($query->toSql())->toBe($expected);

})->with([
            ['sqlite', 'SELECT name, email FROM users'],
            // ['mysql', 'SELECT * FROM `users`'],
            // ['pgsql', 'SELECT * FROM "users"']
        ]);

test('can create select query with column names from string', function ($dialect, $expected) {

    $query = query($dialect)->from('users')->select(['name', 'email']);
    expect($query->toSql())->toBe($expected);

})->with([
            ['sqlite', 'SELECT name, email FROM users'],
            // ['mysql', 'SELECT * FROM `users`'],
            // ['pgsql', 'SELECT * FROM "users"']
        ]);
