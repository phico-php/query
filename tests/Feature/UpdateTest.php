<?php

test('can create update query', function ($dialect, $data, $expected) {

    $query = query($dialect)->table('users')->update($data);
    expect($query->toSql())->toBe($expected);
    expect($query->getParams())->toBe(array_values($data));

})->with([
            [
                'sqlite',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                "UPDATE users SET name = ?, email = ?"
            ],
            // ['SELECT * FROM `users`', 'mysql'],
            // ['SELECT * FROM "users"', 'pgsql']
        ]);

