<?php

test('can use where in clause', function ($dialect, $data, $expected) {

    $query = query()
        ->table('users')
        ->where('created_at', '>', 1)
        ->whereIn('role', ['viewer', 'guest'])
        ->update($data);
    expect($query->toSql($dialect))->toBe($expected);
    expect($query->getParams())->toBe(['Bob', 'bob@example.com', 1, 'viewer', 'guest']);

})->with([
            [
                'mysql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE `users` SET `name` = ?, `email` = ? WHERE `created_at` > ? AND `role` IN (?, ?)'
            ],
            [
                'pgsql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE "users" SET "name" = ?, "email" = ? WHERE "created_at" > ? AND "role" IN (?, ?)'
            ],
            [
                'sqlite',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE "users" SET "name" = ?, "email" = ? WHERE "created_at" > ? AND "role" IN (?, ?)'
            ],
        ]);
test('can use or where in clause', function ($dialect, $data, $expected) {

    $query = query()
        ->table('users')
        ->where('created_at', '>', 1)
        ->orWhereIn('role', ['viewer', 'guest'])
        ->update($data);
    expect($query->toSql($dialect))->toBe($expected);
    expect($query->getParams())->toBe(['Bob', 'bob@example.com', 1, 'viewer', 'guest']);

})->with([
            [
                'mysql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE `users` SET `name` = ?, `email` = ? WHERE `created_at` > ? OR `role` IN (?, ?)'
            ],
            [
                'pgsql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE "users" SET "name" = ?, "email" = ? WHERE "created_at" > ? OR "role" IN (?, ?)'
            ],
            [
                'sqlite',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE "users" SET "name" = ?, "email" = ? WHERE "created_at" > ? OR "role" IN (?, ?)'
            ],
        ]);
test('can use where not in clause', function ($dialect, $data, $expected) {

    $query = query()
        ->table('users')
        ->where('created_at', '>', 1)
        ->whereNotIn('role', ['viewer', 'guest'])
        ->update($data);
    expect($query->toSql($dialect))->toBe($expected);
    expect($query->getParams())->toBe(['Bob', 'bob@example.com', 1, 'viewer', 'guest']);

})->with([
            [
                'mysql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE `users` SET `name` = ?, `email` = ? WHERE `created_at` > ? AND NOT `role` IN (?, ?)'
            ],
            [
                'pgsql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE "users" SET "name" = ?, "email" = ? WHERE "created_at" > ? AND NOT "role" IN (?, ?)'
            ],
            [
                'sqlite',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE "users" SET "name" = ?, "email" = ? WHERE "created_at" > ? AND NOT "role" IN (?, ?)'
            ],
        ]);
test('can use or where not in clause', function ($dialect, $data, $expected) {

    $query = query()
        ->table('users')
        ->where('created_at', '>', 1)
        ->orWhereNotIn('role', ['viewer', 'guest'])
        ->update($data);
    expect($query->toSql($dialect))->toBe($expected);
    expect($query->getParams())->toBe(['Bob', 'bob@example.com', 1, 'viewer', 'guest']);

})->with([
            [
                'mysql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE `users` SET `name` = ?, `email` = ? WHERE `created_at` > ? OR NOT `role` IN (?, ?)'
            ],
            [
                'pgsql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE "users" SET "name" = ?, "email" = ? WHERE "created_at" > ? OR NOT "role" IN (?, ?)'
            ],
            [
                'sqlite',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE "users" SET "name" = ?, "email" = ? WHERE "created_at" > ? OR NOT "role" IN (?, ?)'
            ],
        ]);
