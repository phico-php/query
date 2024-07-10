<?php

test('can create join with minimal fields', function ($dialect, $expected) {

    $query = query()->from('users')->join('history');
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'SELECT * FROM `users` INNER JOIN `history` ON `users`.`id` = `history`.`users_id`'],
            ['pgsql', 'SELECT * FROM "users" INNER JOIN "history" ON "users"."id" = "history"."users_id"'],
            ['sqlite', 'SELECT * FROM "users" INNER JOIN "history" ON "users"."id" = "history"."users_id"'],
        ]);
test('can create join with join columns', function ($dialect, $expected) {

    $query = query()->from('users')->join('history', 'id', 'user_id');
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'SELECT * FROM `users` INNER JOIN `history` ON `users`.`id` = `history`.`user_id`'],
            ['pgsql', 'SELECT * FROM "users" INNER JOIN "history" ON "users"."id" = "history"."user_id"'],
            ['sqlite', 'SELECT * FROM "users" INNER JOIN "history" ON "users"."id" = "history"."user_id"'],
        ]);
