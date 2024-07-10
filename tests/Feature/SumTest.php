<?php

test('can use sum()', function ($dialect, $expected) {

    $query = query()->from('users')->sum('days');
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'SELECT SUM(`days`) AS `sum` FROM `users`'],
            ['pgsql', 'SELECT SUM("days") AS "sum" FROM "users"'],
            ['sqlite', 'SELECT SUM("days") AS "sum" FROM "users"'],
        ]);
test('can use sum() with as', function ($dialect, $expected) {

    $query = query()->from('users')->sum('signins', 'total');
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'SELECT SUM(`signins`) AS `total` FROM `users`'],
            ['pgsql', 'SELECT SUM("signins") AS "total" FROM "users"'],
            ['sqlite', 'SELECT SUM("signins") AS "total" FROM "users"'],
        ]);
