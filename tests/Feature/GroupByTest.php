<?php

test('can create group by clause', function ($dialect, $expected) {

    $query = query($dialect)->from('users')->groupBy('name');
    expect($query->toSql())->toBe($expected);

})->with([
            ['sqlite', 'SELECT * FROM users GROUP BY name'],
            // ['mysql', 'SELECT * FROM `users`'],
            // ['pgsql', 'SELECT * FROM "users"']
        ]);
test('can use multiple group by clauses', function ($dialect, $expected) {

    $query = query($dialect)->from('users')->groupBy('name')->groupBy('email');
    expect($query->toSql())->toBe($expected);

})->with([
            ['sqlite', 'SELECT * FROM users GROUP BY name, email'],
            // ['mysql', 'SELECT * FROM `users`'],
            // ['pgsql', 'SELECT * FROM "users"']
        ]);
