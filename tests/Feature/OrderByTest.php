<?php

test('can create order by clause', function ($dialect, $expected) {

    $query = query()->from('users')->orderBy('name');
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'SELECT * FROM `users` ORDER BY `name`'],
            ['pgsql', 'SELECT * FROM "users" ORDER BY "name"'],
            ['sqlite', 'SELECT * FROM "users" ORDER BY "name"'],
        ]);
test('can create order by clause with ASC', function ($dialect, $expected) {

    $query = query()->from('users')->orderBy('name', 'ASC');
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'SELECT * FROM `users` ORDER BY `name` ASC'],
            ['pgsql', 'SELECT * FROM "users" ORDER BY "name" ASC'],
            ['sqlite', 'SELECT * FROM "users" ORDER BY "name" ASC'],
        ]);
test('can create order by clause with DESC', function ($dialect, $expected) {

    $query = query()->from('users')->orderBy('name', 'DESC');
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'SELECT * FROM `users` ORDER BY `name` DESC'],
            ['pgsql', 'SELECT * FROM "users" ORDER BY "name" DESC'],
            ['sqlite', 'SELECT * FROM "users" ORDER BY "name" DESC'],
        ]);

test('can use multiple order by clauses', function ($dialect, $expected) {

    $query = query()->from('users')->orderBy('name')->orderBy('email', 'desc');
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'SELECT * FROM `users` ORDER BY `name`, `email` DESC'],
            ['pgsql', 'SELECT * FROM "users" ORDER BY "name", "email" DESC'],
            ['sqlite', 'SELECT * FROM "users" ORDER BY "name", "email" DESC'],
        ]);
test('can use functions', function ($dialect, $expected) {

    $query = query()->from('users')->orderBy('RAND()');
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'SELECT * FROM `users` ORDER BY RAND()'],
            ['pgsql', 'SELECT * FROM "users" ORDER BY RAND()'],
            ['sqlite', 'SELECT * FROM "users" ORDER BY RAND()'],
        ]);
