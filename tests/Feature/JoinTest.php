<?php

test('can create join with minimal fields', function ($dialect, $expected) {

    $query = query($dialect)->from('users')->join('history');
    expect($query->toSql())->toBe($expected);

})->with([
            ['sqlite', 'SELECT * FROM users INNER JOIN history ON users.id = history.users_id'],
            // ['mysql', 'SELECT * FROM `users`'],
            // ['pgsql', 'SELECT * FROM "users"']
        ]);
test('can create join with join columns', function ($dialect, $expected) {

    $query = query($dialect)->from('users')->join('history', 'id', 'user_id');
    expect($query->toSql())->toBe($expected);

})->with([
            ['sqlite', 'SELECT * FROM users INNER JOIN history ON users.id = history.user_id'],
            // ['mysql', 'SELECT * FROM `users`'],
            // ['pgsql', 'SELECT * FROM "users"']
        ]);
