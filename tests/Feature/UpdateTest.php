<?php

test('can create update query', function ($dialect, $data, $expected) {

    $query = query()->table('users')->update($data);
    expect($query->toSql($dialect))->toBe($expected);
    expect($query->getParams())->toBe(array_values($data));

})->with([
            [
                'mysql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE `users` SET `name` = ?, `email` = ?'
            ],
            [
                'pgsql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE "users" SET "name" = ?, "email" = ?'
            ],
            [
                'sqlite',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'UPDATE "users" SET "name" = ?, "email" = ?'
            ],
        ]);

