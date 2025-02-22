<?php

test('can use where clause', function ($dialect, $data, $expected) {

    $query = query()
        ->table('users')
        ->where('created_at', '>', 1)
        ->update($data);
    expect($query->toSql($dialect))->toBe($expected);
    expect($query->getParams())->toBe(['Bob', 'bob@example.com', 1]);

})->with([
            [
                'mysql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE `users` SET `name` = ?, `email` = ? WHERE `created_at` > ?'
            ],
            [
                'pgsql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE "users" SET "name" = ?, "email" = ? WHERE "created_at" > ?'
            ],
            [
                'sqlite',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE "users" SET "name" = ?, "email" = ? WHERE "created_at" > ?'
            ],
        ]);
test('can use or where clause', function ($dialect, $data, $expected) {

    $query = query()
        ->table('users')
        ->where('created_at', '>', 1)
        ->orWhere('created_at', '<', 2)
        ->update($data);
    expect($query->toSql($dialect))->toBe($expected);
    expect($query->getParams())->toBe(['Bob', 'bob@example.com', 1, 2]);

})->with([
            [
                'mysql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE `users` SET `name` = ?, `email` = ? WHERE `created_at` > ? OR `created_at` < ?'
            ],
            [
                'pgsql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE "users" SET "name" = ?, "email" = ? WHERE "created_at" > ? OR "created_at" < ?'
            ],
            [
                'sqlite',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE "users" SET "name" = ?, "email" = ? WHERE "created_at" > ? OR "created_at" < ?'
            ],
        ]);
test('can use where not clause', function ($dialect, $data, $expected) {

    $query = query()
        ->table('users')
        ->where('created_at', '>', 1)
        ->whereNot('created_at', '<', 2)
        ->update($data);
    expect($query->toSql($dialect))->toBe($expected);
    expect($query->getParams())->toBe(['Bob', 'bob@example.com', 1, 2]);

})->with([
            [
                'mysql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE `users` SET `name` = ?, `email` = ? WHERE `created_at` > ? AND NOT `created_at` < ?'
            ],
            [
                'pgsql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE "users" SET "name" = ?, "email" = ? WHERE "created_at" > ? AND NOT "created_at" < ?'
            ],
            [
                'sqlite',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE "users" SET "name" = ?, "email" = ? WHERE "created_at" > ? AND NOT "created_at" < ?'
            ],
        ]);
test('can use or where not clause', function ($dialect, $data, $expected) {

    $query = query()
        ->table('users')
        ->where('created_at', '>', 1)
        ->orWhereNot('created_at', '<', 2)
        ->update($data);
    expect($query->toSql($dialect))->toBe($expected);
    expect($query->getParams())->toBe(['Bob', 'bob@example.com', 1, 2]);

})->with([
            [
                'mysql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE `users` SET `name` = ?, `email` = ? WHERE `created_at` > ? OR NOT `created_at` < ?'
            ],
            [
                'pgsql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE "users" SET "name" = ?, "email" = ? WHERE "created_at" > ? OR NOT "created_at" < ?'
            ],
            [
                'sqlite',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE "users" SET "name" = ?, "email" = ? WHERE "created_at" > ? OR NOT "created_at" < ?'
            ],
        ]);
