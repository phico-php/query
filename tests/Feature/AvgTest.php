<?php

test('can use avg()', function ($dialect, $expected) {

    $query = query()->from('users')->avg('days');
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'SELECT AVG(`days`) AS `avg` FROM `users`'],
            ['pgsql', 'SELECT AVG("days") AS "avg" FROM "users"'],
            ['sqlite', 'SELECT AVG("days") AS "avg" FROM "users"'],
        ]);
test('can use avg() with as', function ($dialect, $expected) {

    $query = query()->from('users')->avg('signins', 'average');
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'SELECT AVG(`signins`) AS `average` FROM `users`'],
            ['pgsql', 'SELECT AVG("signins") AS "average" FROM "users"'],
            ['sqlite', 'SELECT AVG("signins") AS "average" FROM "users"'],
        ]);
