<?php

test('can create truncate query', function ($dialect, $expected) {

    $query = query()->table('users')->truncate();
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'TRUNCATE `users`'],
            ['pgsql', 'TRUNCATE "users"'],
            ['sqlite', 'TRUNCATE "users"'],
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


