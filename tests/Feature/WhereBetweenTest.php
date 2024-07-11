<?php

test('can use where in clause', function ($dialect, $data, $expected) {

    $query = query()
        ->table('users')
        ->where('created_at', '>', 1)
        ->whereBetween('age', 18, 30)
        ->update($data);
    expect($query->toSql($dialect))->toBe($expected);
    expect($query->getParams())->toBe(['Bob', 'bob@example.com', 1, 18, 30]);

})->with([
            [
                'mysql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE `users` SET `name` = ?, `email` = ? WHERE `created_at` > ? AND `age` BETWEEN ? AND ?'
            ],
            [
                'pgsql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE "users" SET "name" = ?, "email" = ? WHERE "created_at" > ? AND "age" BETWEEN ? AND ?'
            ],
            [
                'sqlite',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE "users" SET "name" = ?, "email" = ? WHERE "created_at" > ? AND "age" BETWEEN ? AND ?'
            ],
        ]);
test('can use or where in clause', function ($dialect, $data, $expected) {

    $query = query()
        ->table('users')
        ->where('created_at', '>', 1)
        ->orWhereBetween('age', 18, 30)
        ->update($data);
    expect($query->toSql($dialect))->toBe($expected);
    expect($query->getParams())->toBe(['Bob', 'bob@example.com', 1, 18, 30]);

})->with([
            [
                'mysql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE `users` SET `name` = ?, `email` = ? WHERE `created_at` > ? OR `age` BETWEEN ? AND ?'
            ],
            [
                'pgsql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE "users" SET "name" = ?, "email" = ? WHERE "created_at" > ? OR "age" BETWEEN ? AND ?'
            ],
            [
                'sqlite',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE "users" SET "name" = ?, "email" = ? WHERE "created_at" > ? OR "age" BETWEEN ? AND ?'
            ],
        ]);
test('can use where not in clause', function ($dialect, $data, $expected) {

    $query = query()
        ->table('users')
        ->where('created_at', '>', 1)
        ->whereNotBetween('age', 18, 30)
        ->update($data);
    expect($query->toSql($dialect))->toBe($expected);
    expect($query->getParams())->toBe(['Bob', 'bob@example.com', 1, 18, 30]);

})->with([
            [
                'mysql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE `users` SET `name` = ?, `email` = ? WHERE `created_at` > ? AND NOT `age` BETWEEN ? AND ?'
            ],
            [
                'pgsql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE "users" SET "name" = ?, "email" = ? WHERE "created_at" > ? AND NOT "age" BETWEEN ? AND ?'
            ],
            [
                'sqlite',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE "users" SET "name" = ?, "email" = ? WHERE "created_at" > ? AND NOT "age" BETWEEN ? AND ?'
            ],
        ]);
test('can use or where not in clause', function ($dialect, $data, $expected) {

    $query = query()
        ->table('users')
        ->where('created_at', '>', 1)
        ->orWhereNotBetween('age', 18, 30)
        ->update($data);
    expect($query->toSql($dialect))->toBe($expected);
    expect($query->getParams())->toBe(['Bob', 'bob@example.com', 1, 18, 30]);

})->with([
            [
                'mysql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE `users` SET `name` = ?, `email` = ? WHERE `created_at` > ? OR NOT `age` BETWEEN ? AND ?'
            ],
            [
                'pgsql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE "users" SET "name" = ?, "email" = ? WHERE "created_at" > ? OR NOT "age" BETWEEN ? AND ?'
            ],
            [
                'sqlite',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE "users" SET "name" = ?, "email" = ? WHERE "created_at" > ? OR NOT "age" BETWEEN ? AND ?'
            ],
        ]);
