<?php

test('can create select query', function ($dialect, $expected) {

    $query = query()->from('users');
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'SELECT * FROM `users`'],
            ['pgsql', 'SELECT * FROM "users"'],
            ['sqlite', 'SELECT * FROM "users"'],
        ]);

test('can create select query passing table name in constructor', function ($dialect, $expected) {

    $query = query('users');
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'SELECT * FROM `users`'],
            ['pgsql', 'SELECT * FROM "users"'],
            ['sqlite', 'SELECT * FROM "users"'],
        ]);

test('can create select query with column names from string', function ($dialect, $expected) {

    $query = query()->from('users')->select('name, email');
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'SELECT `name`, `email` FROM `users`'],
            ['pgsql', 'SELECT "name", "email" FROM "users"'],
            ['sqlite', 'SELECT "name", "email" FROM "users"'],
        ]);

test('can create select query with column names from array', function ($dialect, $expected) {

    $query = query()->from('users')->select(['name', 'email']);
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'SELECT `name`, `email` FROM `users`'],
            ['pgsql', 'SELECT "name", "email" FROM "users"'],
            ['sqlite', 'SELECT "name", "email" FROM "users"'],
        ]);

test('can create select query with column names specifying table name', function ($dialect, $expected) {

    $query = query()->from('users')->select(['name', 'users.email']);
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'SELECT `name`, `users`.`email` FROM `users`'],
            ['pgsql', 'SELECT "name", "users"."email" FROM "users"'],
            ['sqlite', 'SELECT "name", "users"."email" FROM "users"'],
        ]);
