<?php

test('can use nested where clause', function ($dialect, $expected) {

    $query = query()
        ->table('users')
        ->where('created_at', '>', 1)
        ->where(function ($query) {
            $query->where('is_active', '>', 2);
            $query->orWhere('is_active', '<', 3);
        });
    expect($query->toSql($dialect))->toBe($expected);
    expect($query->getParams())->toBe([1, 2, 3]);

})->with([
            [
                'mysql',
                'SELECT * FROM `users` WHERE `created_at` > ? AND (`is_active` > ? OR `is_active` < ?)'
            ],
            [
                'pgsql',
                'SELECT * FROM "users" WHERE "created_at" > ? AND ("is_active" > ? OR "is_active" < ?)'
            ],
            [
                'sqlite',
                'SELECT * FROM "users" WHERE "created_at" > ? AND ("is_active" > ? OR "is_active" < ?)'
            ],
        ]);

test('can use nested where clause with update', function ($dialect, $data, $expected) {

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

test('can use nested or where clause', function ($dialect, $expected) {

    $query = query()
        ->table('users')
        ->where('created_at', '>', 1)
        ->orWhere(function ($query) {
            $query->where('is_active', '>', 2);
            $query->orWhere('is_active', '<', 3);
        });
    expect($query->toSql($dialect))->toBe($expected);
    expect($query->getParams())->toBe([1, 2, 3]);

})->with([
            [
                'mysql',
                'SELECT * FROM `users` WHERE `created_at` > ? OR (`is_active` > ? OR `is_active` < ?)'
            ],
            [
                'pgsql',
                'SELECT * FROM "users" WHERE "created_at" > ? OR ("is_active" > ? OR "is_active" < ?)'
            ],
            [
                'sqlite',
                'SELECT * FROM "users" WHERE "created_at" > ? OR ("is_active" > ? OR "is_active" < ?)'
            ],
        ]);

test('can use double nested where clause', function ($dialect, $expected) {

    $query = query()
        ->table('users')
        ->where('created_at', '>', 1)
        ->where(function ($query) {
            $query->where('is_active', '>', 2);
            $query->where(function ($query) {
                $query->whereBetween('age', 3, 4);
                $query->orWhereBetween('age', 5, 6);
            });
        });
    expect($query->toSql($dialect))->toBe($expected);
    expect($query->getParams())->toBe([1, 2, 3, 4, 5, 6]);

})->with([
            [
                'mysql',
                'SELECT * FROM `users` WHERE `created_at` > ? AND (`is_active` > ? AND (`age` BETWEEN ? AND ? OR `age` BETWEEN ? AND ?))'
            ],
            [
                'pgsql',
                'SELECT * FROM "users" WHERE "created_at" > ? AND ("is_active" > ? AND ("age" BETWEEN ? AND ? OR "age" BETWEEN ? AND ?))'
            ],
            [
                'sqlite',
                'SELECT * FROM "users" WHERE "created_at" > ? AND ("is_active" > ? AND ("age" BETWEEN ? AND ? OR "age" BETWEEN ? AND ?))'
            ],
        ]);

test('can use nested whereIn clause with query', function ($dialect, $data, $expected) {

    $query = query()
        ->from('posts')
        ->where('rating', '>', 1)
        ->whereIn('category_id', function ($query) {
            $query
                ->select('id')
                ->from('categories')
                ->where('tags', 'LIKE', 'foo');
        });
    expect($query->toSql($dialect))->toBe($expected);
    expect($query->getParams())->toBe([1, 'foo']);

})->with([
            [
                'mysql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'SELECT * FROM `posts` WHERE `rating` > ? AND (`category_id` IN (SELECT `id` FROM `categories` WHERE `tags` LIKE ?))'
            ],
            [
                'pgsql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'SELECT * FROM "posts" WHERE "rating" > ? AND ("category_id" IN (SELECT "id" FROM "categories" WHERE "tags" LIKE ?))'
            ],
            [
                'sqlite',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'SELECT * FROM "posts" WHERE "rating" > ? AND ("category_id" IN (SELECT "id" FROM "categories" WHERE "tags" LIKE ?))'
            ],
        ]);
