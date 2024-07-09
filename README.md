# Query

Lightweight SQL query builder designed for use with Phico.

Query has no dependencies and can be imported into any project, it generates plain SQL with support for MySQL, PostgreSQL and SQLite.

## Installation

Using composer

```sh
composer require pico-php/query
```

## Usage

This is an early release and the documentation is not up to date, however it broadly follows Laravel Eloquent or the earlier project indgy/phluent, please refer to the [Phluent documentation](https://indgy.github.io/phluent/) but be aware that there are subtle differences, notably the order of arguments is fixed, now that we can use named arguments it's less of an issue but means that the method signatures are not compatible with Eloquent/Phluent.

```php

$query = query('sqlite')->from('users')->toSql();
// SELECT * from users

$query = query('sqlite')->select('name, email')->from('users')->toSql();
// SELECT name, email from users

// the order of the chain is not that important*
$query = query('sqlite')->from('users')->select('name, email')->toSql();
// SELECT name, email from users

// mysql and postgresql are supported
$query = query('mysql');
$query = query('pgsql');

// select accepts arrays of expressions or a raw string
$query->select(['name', 'email']);

// some aggregates are supported, count(), avg(), min(), max(), sum()
$query->from('users')->count();
// SELECT COUNT(*) AS count FROM users

// specify the column/expression to count as the first argument
$query->from('users')->count('id');
// SELECT COUNT(id) AS count FROM users

// specify the result variable name as the second argument
$query->from('users')->count('id', 'c');
// SELECT COUNT(id) AS c FROM users

// use getParams() to return the query parameter values as an array
$query->getParams();
[ ... ]

```

\*Until it is

## Issues

If you discover any bugs or issues with behaviour or performance please create an issue, if you are able a pull request with a fix would be most helpful.

Please make sure to update tests as appropriate.

For major changes, please open an issue first to discuss what you would like to change.

## License

[BSD-3-Clause](https://choosealicense.com/licenses/bsd-3-clause/)
