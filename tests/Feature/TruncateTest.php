<?php

test('can create truncate query', function ($dialect, $expected) {

    $query = query($dialect)->table('users')->truncate();
    expect($query->toSql())->toBe($expected);

})->with([
            [
                'sqlite',
                "TRUNCATE users"
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


