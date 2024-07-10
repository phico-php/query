<?php

test('can create insert query', function ($dialect, $data, $expected) {

    $query = query()->table('users')->insert($data);
    expect($query->toSql($dialect))->toBe($expected);
    expect($query->getParams())->toBe(array_values($data));

})->with([
            [
                'mysql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'INSERT INTO `users` (`name`, `email`) VALUES (?, ?)'
            ],
            [
                'pgsql',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'INSERT INTO "users" ("name", "email") VALUES (?, ?)'
            ],
            [
                'sqlite',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                'INSERT INTO "users" ("name", "email") VALUES (?, ?)'
            ],
        ]);

