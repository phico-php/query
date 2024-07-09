<?php

test('can use avg()', function ($dialect, $expected) {

    $query = query($dialect)->from('users')->avg('days');
    expect($query->toSql())->toBe($expected);

})->with([
            ['sqlite', 'SELECT AVG(days) AS avg FROM users'],
            // ['mysql', 'SELECT * FROM `users`'],
            // ['pgsql', 'SELECT * FROM "users"']
        ]);
test('can use avg() with as', function ($dialect, $expected) {

    $query = query($dialect)->from('users')->avg('signins', 'average');
    expect($query->toSql())->toBe($expected);

})->with([
            ['sqlite', 'SELECT AVG(signins) AS average FROM users'],
            // ['mysql', 'SELECT * FROM `users`'],
            // ['pgsql', 'SELECT * FROM "users"']
        ]);
