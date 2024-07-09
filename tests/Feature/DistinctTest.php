<?php

test('can create select distinct query ', function ($dialect, $expected) {

    $query = query($dialect)->from('users')->select('name, email')->distinct();
    expect($query->toSql())->toBe($expected);

})->with([
            ['sqlite', 'SELECT DISTINCT name, email FROM users'],
            // ['mysql', 'SELECT * FROM `users`'],
            // ['pgsql', 'SELECT * FROM "users"']
        ]);
