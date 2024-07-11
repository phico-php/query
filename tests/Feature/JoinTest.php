<?php

test('can create join with minimal fields', function ($dialect, $expected) {

    $query = query()->from('users')->join('history');
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'SELECT * FROM `users` JOIN `history` ON `users`.`id` = `history`.`users_id`'],
            ['pgsql', 'SELECT * FROM "users" JOIN "history" ON "users"."id" = "history"."users_id"'],
            ['sqlite', 'SELECT * FROM "users" JOIN "history" ON "users"."id" = "history"."users_id"'],
        ]);
test('can create join with join columns', function ($dialect, $expected) {

    $query = query()->from('users')->join('history', 'id', 'user_id');
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'SELECT * FROM `users` JOIN `history` ON `users`.`id` = `history`.`user_id`'],
            ['pgsql', 'SELECT * FROM "users" JOIN "history" ON "users"."id" = "history"."user_id"'],
            ['sqlite', 'SELECT * FROM "users" JOIN "history" ON "users"."id" = "history"."user_id"'],
        ]);

test('can create inner join with minimal fields', function ($dialect, $expected) {

    $query = query()->from('users')->innerJoin('history');
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'SELECT * FROM `users` INNER JOIN `history` ON `users`.`id` = `history`.`users_id`'],
            ['pgsql', 'SELECT * FROM "users" INNER JOIN "history" ON "users"."id" = "history"."users_id"'],
            ['sqlite', 'SELECT * FROM "users" INNER JOIN "history" ON "users"."id" = "history"."users_id"'],
        ]);

test('can create outer join with minimal fields', function ($dialect, $expected) {

    $query = query()->from('users')->outerJoin('history');
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'SELECT * FROM `users` OUTER JOIN `history` ON `users`.`id` = `history`.`users_id`'],
            ['pgsql', 'SELECT * FROM "users" OUTER JOIN "history" ON "users"."id" = "history"."users_id"'],
            ['sqlite', 'SELECT * FROM "users" OUTER JOIN "history" ON "users"."id" = "history"."users_id"'],
        ]);
test('can create left join with minimal fields', function ($dialect, $expected) {

    $query = query()->from('users')->leftJoin('history');
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'SELECT * FROM `users` LEFT JOIN `history` ON `users`.`id` = `history`.`users_id`'],
            ['pgsql', 'SELECT * FROM "users" LEFT JOIN "history" ON "users"."id" = "history"."users_id"'],
            ['sqlite', 'SELECT * FROM "users" LEFT JOIN "history" ON "users"."id" = "history"."users_id"'],
        ]);
test('can create right join with minimal fields', function ($dialect, $expected) {

    $query = query()->from('users')->rightJoin('history');
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'SELECT * FROM `users` RIGHT JOIN `history` ON `users`.`id` = `history`.`users_id`'],
            ['pgsql', 'SELECT * FROM "users" RIGHT JOIN "history" ON "users"."id" = "history"."users_id"'],
            ['sqlite', 'SELECT * FROM "users" RIGHT JOIN "history" ON "users"."id" = "history"."users_id"'],
        ]);
test('can create full join with minimal fields', function ($dialect, $expected) {

    $query = query()->from('users')->fullJoin('history');
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'SELECT * FROM `users` FULL JOIN `history` ON `users`.`id` = `history`.`users_id`'],
            ['pgsql', 'SELECT * FROM "users" FULL JOIN "history" ON "users"."id" = "history"."users_id"'],
            ['sqlite', 'SELECT * FROM "users" FULL JOIN "history" ON "users"."id" = "history"."users_id"'],
        ]);
test('can create self join with minimal fields', function ($dialect, $expected) {

    $query = query()->from('users')->selfJoin('history');
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'SELECT * FROM `users` SELF JOIN `history` ON `users`.`id` = `history`.`users_id`'],
            ['pgsql', 'SELECT * FROM "users" SELF JOIN "history" ON "users"."id" = "history"."users_id"'],
            ['sqlite', 'SELECT * FROM "users" SELF JOIN "history" ON "users"."id" = "history"."users_id"'],
        ]);
test('can create cross join with minimal fields', function ($dialect, $expected) {

    $query = query()->from('users')->crossJoin('history');
    expect($query->toSql($dialect))->toBe($expected);

})->with([
            ['mysql', 'SELECT * FROM `users` CROSS JOIN `history` ON `users`.`id` = `history`.`users_id`'],
            ['pgsql', 'SELECT * FROM "users" CROSS JOIN "history" ON "users"."id" = "history"."users_id"'],
            ['sqlite', 'SELECT * FROM "users" CROSS JOIN "history" ON "users"."id" = "history"."users_id"'],
        ]);
