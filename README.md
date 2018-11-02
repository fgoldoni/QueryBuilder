# PHP  | Query Builder

[![Build Status](https://travis-ci.org/fgoldoni/QueryBuilder.svg?branch=master)](https://travis-ci.org/fgoldoni/QueryBuilder)
[![Coverage Status](https://coveralls.io/repos/github/fgoldoni/QueryBuilder/badge.svg?branch=master)](https://coveralls.io/github/fgoldoni/QueryBuilder?branch=master)

PHP SQL query builder using PDO

## Features

* Allows you to perform complex queries with little code (select, insert, update and delete)

* **Hydration** Ability to return a collection of objects:

## Getting Started

Create a new PDO instance, and pass the instance to Query:
```php
use Goldoni\Builder\Query;
....
$pdo = new \PDO('mysql:dbname=goldoni;host=localhost;charset=utf8', 'root');
$query = (new Query($pdo))
```
### Prerequisites

What things you need to install the software and how to install them

```
"require": {
    "php": ">=7.2.0"
}
```

### Installing

```php
composer require goldoni/php7.2-query-builder
```

## Examples

#### select
```php
$query = (new Query())->from('users')->select('first_name');
```
build the query below
```
SELECT first_name FROM users
```

#### where
```php
$query = (new Query())
            ->from('users', 'u')
            ->where('first_name = :first_name OR email = :email', 'phone = :phone');
            
$query2 = (new Query())
            ->from('users', 'u')
            ->where('first_name = :first_name OR email = :email')
            ->where('mobile = :mobile');
```
build the query below
```
SELECT * FROM users as u WHERE (first_name = :first_name OR email = :email) AND (phone = :phone)

SELECT * FROM users as u WHERE (first_name = :first_name OR email = :email) AND (mobile = :mobile)
```

## Versioning

We use 1.1.1

## Authors

* **Goldoni Fouotsa** - *Initial work*

## License

This project is licensed under the MIT License
