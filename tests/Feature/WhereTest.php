<?php

test('can use where clause', function ($dialect, $data, $expected) {

    $query = query($dialect)
        ->table('users')
        ->where('created_at', '>', 1)
        ->update($data);
    expect($query->toSql())->toBe($expected);
    expect($query->getParams())->toBe(array_values($data));

})->with([
            [
                'sqlite',
                [
                    'name' => 'Bob',
                    'email' => 'bob@example.com'
                ],
                "UPDATE users SET name = ?, email = ? WHERE created_at > ?"
            ],
            // ['SELECT * FROM `users`', 'mysql'],
            // ['SELECT * FROM "users"', 'pgsql']
        ]);

