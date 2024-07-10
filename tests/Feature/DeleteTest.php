<?php

test('can delete', function ($dialect, $expected) {

    $query = query()->table('users')->delete();
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'DELETE FROM `users`'],
            ['pgsql', 'DELETE FROM "users"'],
            ['sqlite', 'DELETE FROM "users"'],
        ]);
test('can delete with a limit', function ($dialect, $limit, $expected) {

    $query = query()->table('users')->limit($limit)->delete();
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 5, 'DELETE FROM `users` LIMIT 5'],
            ['pgsql', 5, 'DELETE FROM "users" LIMIT 5'],
            ['sqlite', 5, 'DELETE FROM "users" LIMIT 5'],
        ]);
test('can delete with a limit and offset', function ($dialect, $limit, $offset, $expected) {

    $query = query()->table('users')->limit($limit, $offset)->delete();
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 5, 3, 'DELETE FROM `users` LIMIT 5 OFFSET 3'],
            ['pgsql', 5, 3, 'DELETE FROM "users" LIMIT 5 OFFSET 3'],
            ['sqlite', 5, 3, 'DELETE FROM "users" LIMIT 5 OFFSET 3'],
        ]);
test('can create delete query with where clause', function ($dialect, $data, $expected) {

    $query = query()->table('users')->where('deleted_at', '<', 123456)->delete();
    expect($query->toSql($dialect))->toBe($expected);
    expect($query->getParams())->toBe([123456]);

})->with([
            ['mysql', [123456], 'DELETE FROM `users` WHERE `deleted_at` < ?'],
            ['pgsql', [123456], 'DELETE FROM "users" WHERE "deleted_at" < ?'],
            ['sqlite', [123456], 'DELETE FROM "users" WHERE "deleted_at" < ?'],
        ]);


