<?php

test('can use sum()', function ($dialect, $expected) {

    $query = query($dialect)->from('users')->sum('days');
    expect($query->toSql())->toBe($expected);

})->with([
            ['sqlite', 'SELECT SUM(days) AS sum FROM users'],
            // ['mysql', 'SELECT * FROM `users`'],
            // ['pgsql', 'SELECT * FROM "users"']
        ]);
test('can use sum() with as', function ($dialect, $expected) {

    $query = query($dialect)->from('users')->sum('signins', 'total');
    expect($query->toSql())->toBe($expected);

})->with([
            ['sqlite', 'SELECT SUM(signins) AS total FROM users'],
            // ['mysql', 'SELECT * FROM `users`'],
            // ['pgsql', 'SELECT * FROM "users"']
        ]);
