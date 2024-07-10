<?php

test('can create select distinct query ', function ($dialect, $expected) {

    $query = query()->from('users')->select('name, email')->distinct();
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'SELECT DISTINCT `name`, `email` FROM `users`'],
            ['pgsql', 'SELECT DISTINCT "name", "email" FROM "users"'],
            ['sqlite', 'SELECT DISTINCT "name", "email" FROM "users"'],
        ]);
