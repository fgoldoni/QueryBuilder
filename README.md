# PHP  | Query Builder

[![Build Status](https://travis-ci.org/fgoldoni/QueryBuilder.svg?branch=master)](https://travis-ci.org/fgoldoni/QueryBuilder)
[![Coverage Status](https://coveralls.io/repos/github/fgoldoni/QueryBuilder/badge.svg?branch=master)](https://coveralls.io/github/fgoldoni/QueryBuilder?branch=master)

PHP SQL query builder using PDO

## Features

* Allows you to perform complex queries with little code
    - [select](https://github.com/fgoldoni/QueryBuilder#select)
    - [insert](https://github.com/fgoldoni/QueryBuilder#insert)
    - update 
    - delete 
    - [where](https://github.com/fgoldoni/QueryBuilder#where)
    - [params](https://github.com/fgoldoni/QueryBuilder#params)
    - [count](https://github.com/fgoldoni/QueryBuilder#count)
    - [orderBy](https://github.com/fgoldoni/QueryBuilder#orderBy)
    - [groupBy](https://github.com/fgoldoni/QueryBuilder#groupBy)
    - [joins](https://github.com/fgoldoni/QueryBuilder#joins)
    - [limit](https://github.com/fgoldoni/QueryBuilder#limit)
    - [fetchAll](https://github.com/fgoldoni/QueryBuilder#fetchAll)
    - [fetch](https://github.com/fgoldoni/QueryBuilder#fetch)
    - [fetchOrFail](https://github.com/fgoldoni/QueryBuilder#fetchOrFail)
    - [execute](https://github.com/fgoldoni/QueryBuilder#execute)
    - paginate

* **Hydration** Ability to return a collection of objects:
    - into(Demo::class)

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

#### insert
```php
$query = (new Query($this->pdo))
            ->insert(
                'users',
                [
                    'first_name' => ':first_name',
                    'last_name'  => ':last_name',
                    'email'      => ':email',
                    'mobile'     => ':mobile',
                    'phone'      => ':phone',
                ]
            );
```
build the query below
```
INSERT INTO users (first_name, last_name, email, mobile, phone) VALUES (:first_name, :last_name, :email, :mobile, :phone)
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

#### params
```php
$user = (new Query($this->pdo))
            ->from('users', 'u')
            ->where('id = :id')
            ->params(['id' => 1]);
```

#### count
```php
$usersCount = (new Query($this->pdo))
            ->from('users', 'u')
            ->where('u.id < :number')
            ->params([
                'number' => 5
            ])
            ->count();
```

#### orderBy
```php
$query = (new Query($this->pdo))
            ->from('users', 'u')
            ->orderBy('u.id', 'DESC');
```
build the query below
```
SELECT * FROM users as u ORDER BY u.id DESC
```

#### groupBy
```php
$query = (new Query())
            ->select('u.first_name', 'COUNT(id)')
            ->from('users', 'u')
            ->groupBy('u.updated_at');
```
build the query below
```
SELECT u.first_name, COUNT(id) FROM users as u GROUP BY u.updated_at
```
#### joins
```php
 $query = (new Query())
            ->from('users', 'u')
            ->select('first_name')
            ->join('posts as p', 'u.id = p.user_id');
            
 $query = (new Query())
            ->from('users', 'u')
            ->select('first_name')
            ->join('posts as p2', 'u.id = p2.user_id', 'inner');
```
build the query below
```
SELECT first_name FROM users as u LEFT JOIN posts as p ON u.id = p.user_id

SELECT first_name FROM users as u INNER JOIN posts as p2 ON u.id = p2.user_id
```

#### limit
```php
$query = (new Query($this->pdo))
            ->from('users', 'u')
            ->where('first_name = :first_name OR email = :email')
            ->limit(5);
```
build the query below
```
SELECT * FROM users as u WHERE (first_name = :first_name OR email = :email) LIMIT 0, 5
```
#### fetchAll
```php
$query = (new Query($this->pdo))->from('users')->select('first_name')->fetchAll();
```

#### fetch
```php
$user = (new Query($this->pdo))
            ->from('users', 'u')
            ->where('id = :id')
            ->params(['id' => 1])
            ->fetch();
```

#### fetchOrFail
```php
$user = (new Query($this->pdo))
            ->from('users', 'u')
            ->where('id = :id')
            ->params(['id' => 100])
            ->fetchOrFail();
```
#### execute
```php
$query = (new Query($this->pdo))
            ->insert(
                'users',
                [
                    'first_name' => ':first_name',
                    'last_name'  => ':last_name',
                    'email'      => ':email',
                    'mobile'     => ':mobile',
                    'phone'      => ':phone',
                ]
            )
            ->execute();
```

## Hydration
```php
use Goldoni\Builder\Entities\Demo;
...
$demos = (new Query($this->pdo))
            ->from('users', 'u')
            ->into(Demo::class)
            ->fetchAll();

$demo1 = $demos[0]; 

// get_class($demo1) === Demo::class  

echo $demo1->firstName; 

$demo2 = (new Query($this->pdo))
            ->from('users', 'u')
            ->where('id = :id')
            ->into(Demo::class)
            ->params(['id' => 2])
            ->fetch();
            
// get_class($demo2) === Demo::class      

echo $demo2->firstName;
```

```
var_dump($demo2 instanceof Demo::class); // TRUE
var_dump($demo2 instanceof Demo::class); // TRUE
```
## Versioning

We use 1.1.4

## Authors

* **Goldoni Fouotsa** - *Initial work*

## License

This project is licensed under the MIT License
