<?php

test('can create insert query', function ($dialect, $data, $expected) {

    $query = query($dialect)->table('users')->insert($data);
    expect($query->toSql())->toBe($expected);
    expect($query->getParams())->toBe(array_values($data));

})->with([
            [
                'sqlite',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                "INSERT INTO users (name, email) VALUES (?, ?)"
            ],
            // ['SELECT * FROM `users`', 'mysql'],
            // ['SELECT * FROM "users"', 'pgsql']
        ]);

