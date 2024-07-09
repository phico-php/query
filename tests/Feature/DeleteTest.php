<?php

test('can delete', function ($dialect, $expected) {

    $query = query($dialect)->table('users')->delete();
    expect($query->toSql())->toBe($expected);

})->with([
            [
                'sqlite',
                "DELETE FROM users"
            ],
            // ['SELECT * FROM `users`', 'mysql'],
            // ['SELECT * FROM "users"', 'pgsql']
        ]);
test('can delete with a limit', function ($dialect, $limit, $expected) {

    $query = query($dialect)->table('users')->limit($limit)->delete();
    expect($query->toSql())->toBe($expected);

})->with([
            [
                'sqlite',
                5,
                "DELETE FROM users LIMIT 5"
            ],
            // ['SELECT * FROM `users`', 'mysql'],
            // ['SELECT * FROM "users"', 'pgsql']
        ]);
test('can delete with a limit and offset', function ($dialect, $limit, $offset, $expected) {

    $query = query($dialect)->table('users')->limit($limit, $offset)->delete();
    expect($query->toSql())->toBe($expected);

})->with([
            [
                'sqlite',
                5,
                3,
                "DELETE FROM users LIMIT 5 OFFSET 3"
            ],
            // ['SELECT * FROM `users`', 'mysql'],
            // ['SELECT * FROM "users"', 'pgsql']
        ]);
// test('can create delete query with where clause', function ($dialect, $data, $expected) {

//     $query = query($dialect)->table('users')->delete();
//     expect($query->toSql())->toBe($expected);
//     expect($query->getParams())->toBe(array_values($data));

// })->with([
//             [
//                 'sqlite',
//                 [
//                     'name' => 'Bob',
//                     'email' => 'bob@example.com'
//                 ],
//                 "INSERT INTO users (name, email) VALUES (?, ?)"
//             ],
//             // ['SELECT * FROM `users`', 'mysql'],
//             // ['SELECT * FROM "users"', 'pgsql']
//         ]);


