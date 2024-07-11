<?php

test('can use having clause with aggregte', function ($dialect, $expected) {

    $query = query()->from('users')->groupBy('name')->having('AVG(age)', '=', 1);
    expect($query->toSql($dialect))->toBe($expected);
    expect($query->getParams())->toBe([1]);

})->with([
            ['mysql', 'SELECT * FROM `users` GROUP BY `name` HAVING AVG(`age`) = ?'],
            ['pgsql', 'SELECT * FROM "users" GROUP BY "name" HAVING AVG("age") = ?'],
            ['sqlite', 'SELECT * FROM "users" GROUP BY "name" HAVING AVG("age") = ?'],
        ]);
test('can use and having clause with aggregate', function ($dialect, $expected) {

    $query = query()->from('users')->groupBy('name')->having('AVG(age)', '=', 1)->having('MAX(age)', '<', 2);
    expect($query->toSql($dialect))->toBe($expected);
    expect($query->getParams())->toBe([1, 2]);

})->with([
            ['mysql', 'SELECT * FROM `users` GROUP BY `name` HAVING AVG(`age`) = ? AND MAX(`age`) < ?'],
            ['pgsql', 'SELECT * FROM "users" GROUP BY "name" HAVING AVG("age") = ? AND MAX("age") < ?'],
            ['sqlite', 'SELECT * FROM "users" GROUP BY "name" HAVING AVG("age") = ? AND MAX("age") < ?'],
        ]);
test('can use or having clause with aggregate', function ($dialect, $expected) {

    $query = query()->from('users')->groupBy('name')->having('AVG(age)', '=', 1)->orHaving('MAX(age)', '<', 2);
    expect($query->toSql($dialect))->toBe($expected);
    expect($query->getParams())->toBe([1, 2]);

})->with([
            ['mysql', 'SELECT * FROM `users` GROUP BY `name` HAVING AVG(`age`) = ? OR MAX(`age`) < ?'],
            ['pgsql', 'SELECT * FROM "users" GROUP BY "name" HAVING AVG("age") = ? OR MAX("age") < ?'],
            ['sqlite', 'SELECT * FROM "users" GROUP BY "name" HAVING AVG("age") = ? OR MAX("age") < ?'],
        ]);
test('can use having clause', function ($dialect, $expected) {

    $query = query()->from('users')->groupBy('name')->having('age', '=', 1);
    expect($query->toSql($dialect))->toBe($expected);
    expect($query->getParams())->toBe([1]);

})->with([
            ['mysql', 'SELECT * FROM `users` GROUP BY `name` HAVING `age` = ?'],
            ['pgsql', 'SELECT * FROM "users" GROUP BY "name" HAVING "age" = ?'],
            ['sqlite', 'SELECT * FROM "users" GROUP BY "name" HAVING "age" = ?'],
        ]);
/*
        test('can use not having clause', function ($dialect, $expected) {

    $query = query()->from('users')->groupBy('name')->having('AVG(age)', '=', 1)->notHaving('MAX(age)', '<', 2);
    expect($query->toSql($dialect))->toBe($expected);
    expect($query->getParams())->toBe([1, 2]);

})->with([
            ['mysql', 'SELECT * FROM `users` GROUP BY `name` HAVING AVG(`age`) = ? AND NOT MAX(`age`) < ?'],
            ['pgsql', 'SELECT * FROM "users" GROUP BY "name" HAVING AVG("age") = ? AND NOT MAX("age") < ?'],
            ['sqlite', 'SELECT * FROM "users" GROUP BY "name" HAVING AVG("age") = ? AND NOT MAX("age") < ?'],
        ]);
test('can use or not having clause', function ($dialect, $expected) {

    $query = query()->from('users')->groupBy('name')->having('AVG(age)', '=', 1)->orNotHaving('MAX(age)', '<', 2);
    expect($query->toSql($dialect))->toBe($expected);
    expect($query->getParams())->toBe([1, 2]);

})->with([
            ['mysql', 'SELECT * FROM `users` GROUP BY `name` HAVING AVG(`age`) = ? OR NOT MAX(`age`) < ?'],
            ['pgsql', 'SELECT * FROM "users" GROUP BY "name" HAVING AVG("age") = ? OR NOT MAX("age") < ?'],
            ['sqlite', 'SELECT * FROM "users" GROUP BY "name" HAVING AVG("age") = ? OR NOT MAX("age") < ?'],
        ]);
*/
