<?php

test('can use nested where clause', function ($dialect, $data, $expected) {

    $query = query()
        ->table('users')
        ->where('created_at', '>', 1)
        ->where(function ($query) {
            $query->where('is_active', '>', 2);
            $query->orWhere('is_active', '<', 3);
        })
        ->update($data);
    expect($query->toSql($dialect))->toBe($expected);
    expect($query->getParams())->toBe(['Bob', 'bob@example.com', 1, 2, 3]);

})->with([
            [
                'mysql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE `users` SET `name` = ?, `email` = ? WHERE `created_at` > ? AND (`is_active` > ? OR `is_active` < ?)'
            ],
            [
                'pgsql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE "users" SET "name" = ?, "email" = ? WHERE "created_at" > ? AND ("is_active" > ? OR "is_active" < ?)'
            ],
            [
                'sqlite',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE "users" SET "name" = ?, "email" = ? WHERE "created_at" > ? AND ("is_active" > ? OR "is_active" < ?)'
            ],
        ]);
test('can use nested or where clause', function ($dialect, $data, $expected) {

    $query = query()
        ->table('users')
        ->where('created_at', '>', 1)
        ->orWhere(function ($query) {
            $query->where('is_active', '>', 2);
            $query->orWhere('is_active', '<', 3);
        })
        ->update($data);
    expect($query->toSql($dialect))->toBe($expected);
    expect($query->getParams())->toBe(['Bob', 'bob@example.com', 1, 2, 3]);

})->with([
            [
                'mysql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE `users` SET `name` = ?, `email` = ? WHERE `created_at` > ? OR (`is_active` > ? OR `is_active` < ?)'
            ],
            [
                'pgsql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE "users" SET "name" = ?, "email" = ? WHERE "created_at" > ? OR ("is_active" > ? OR "is_active" < ?)'
            ],
            [
                'sqlite',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE "users" SET "name" = ?, "email" = ? WHERE "created_at" > ? OR ("is_active" > ? OR "is_active" < ?)'
            ],
        ]);
test('can use double nested where clause', function ($dialect, $data, $expected) {

    $query = query()
        ->table('users')
        ->where('created_at', '>', 1)
        ->where(function ($query) {
            $query->where('is_active', '>', 2);
            $query->where(function ($query) {
                $query->whereBetween('age', 3, 4);
                $query->orWhereBetween('age', 5, 6);
            });
        })
        ->update($data);
    expect($query->toSql($dialect))->toBe($expected);
    expect($query->getParams())->toBe(['Bob', 'bob@example.com', 1, 2, 3, 4, 5, 6]);

})->with([
            [
                'mysql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE `users` SET `name` = ?, `email` = ? WHERE `created_at` > ? AND (`is_active` > ? AND (`age` BETWEEN ? AND ? OR `age` BETWEEN ? AND ?))'
            ],
            [
                'pgsql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE "users" SET "name" = ?, "email" = ? WHERE "created_at" > ? AND ("is_active" > ? AND ("age" BETWEEN ? AND ? OR "age" BETWEEN ? AND ?))'
            ],
            [
                'sqlite',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE "users" SET "name" = ?, "email" = ? WHERE "created_at" > ? AND ("is_active" > ? AND ("age" BETWEEN ? AND ? OR "age" BETWEEN ? AND ?))'
            ],
        ]);


