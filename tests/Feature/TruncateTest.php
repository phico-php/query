<?php

test('can create truncate query', function ($dialect, $expected) {

    $query = query('users')->truncate();
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'TRUNCATE `users`'],
            ['pgsql', 'TRUNCATE "users"'],
            ['sqlite', 'TRUNCATE "users"'],
        ]);
test('can create truncate query using from()', function ($dialect, $expected) {

    $query = query()->from('users')->truncate();
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'TRUNCATE `users`'],
            ['pgsql', 'TRUNCATE "users"'],
            ['sqlite', 'TRUNCATE "users"'],
        ]);
test('can create truncate query using table()', function ($dialect, $expected) {

    $query = query()->table('users')->truncate();
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'TRUNCATE `users`'],
            ['pgsql', 'TRUNCATE "users"'],
            ['sqlite', 'TRUNCATE "users"'],
        ]);



