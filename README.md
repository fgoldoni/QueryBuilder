# PHP  | Query Builder

[![Build Status](https://travis-ci.org/fgoldoni/QueryBuilder.svg?branch=master)](https://travis-ci.org/fgoldoni/QueryBuilder)
[![Coverage Status](https://coveralls.io/repos/github/fgoldoni/QueryBuilder/badge.svg?branch=master)](https://coveralls.io/github/fgoldoni/QueryBuilder?branch=master)
<br/>
<img src="https://img.shields.io/badge/PHP-7.2-blue.svg?style=plastic">
<br/>
PHP Query builder, Paginate and Hydratation using PDO

## Features

* Allows you to perform complex queries with little code
    - [select](https://github.com/fgoldoni/QueryBuilder#select)
    - [insert](https://github.com/fgoldoni/QueryBuilder#insert)
    - [update](https://github.com/fgoldoni/QueryBuilder#update)
    - [delete](https://github.com/fgoldoni/QueryBuilder#delete)
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

* **Pagination** 
    - [paginate](https://github.com/fgoldoni/QueryBuilder#paginate)
* **Hydration** Ability to return a collection of objects:
    - [into(Demo::class)](https://github.com/fgoldoni/QueryBuilder#Hydration)

## Getting Started

Create a new PDO instance, and pass the instance to Query:
```php
use Goldoni\Builder\Query;
....
$pdo = new \PDO('mysql:dbname=goldoni;host=localhost;charset=utf8', 'root', 'root');
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
            
$query1 = (new Query($this->pdo))
            ->insert('users')
            ->value([
                'first_name' => ':first_name',
                'last_name'  => ':last_name',
                'email'      => ':email',
                'phone'      => ':phone'
            ]);
```
build the query below
```
INSERT INTO users (first_name, last_name, email, mobile, phone) VALUES (:first_name, :last_name, :email, :mobile, :phone)
```

insert with ->execute()
```php
$data = [
    'id' => 12,
    'first_name' => 'Joe3',
    'last_name'  => 'Doe3',
    'email'      => 'joe@contact.de',
    'phone'      => '+0172222222'
];

$query = (new Query($this->pdo))
    ->insert(
        'users',
        [
            'id' => ':id',
            'first_name' => ':first_name',
            'last_name'  => ':last_name',
            'email'      => ':email',
            'phone'      => ':phone'
        ]
    )->params($data)
    ->execute();
```
#### update
```php
$data = [
    'first_name' => 'Joe3',
    'last_name'  => 'Doe3',
    'email'      => 'joe@contact.de'
];
$query = (new Query($this->pdo))
        ->update(
            'users',
            [
                'first_name' => ':first_name',
                'last_name'  => ':last_name',
                'email'      => ':email'
            ],
            2
        )
        ->params($data);
            
$query1 = (new Query($this->pdo))
            ->update('users')
            ->set([
                'first_name' => ':first_name',
                'last_name'  => ':last_name',
                'email'      => ':email'
            ])
            ->where('id = :id')
            ->params($data);
```
build the query below
```
UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email WHERE (id = :id)
```

update with ->execute()
```php
$data = [
    'first_name' => 'Joe',
    'last_name'  => 'Doe',
    'email'      => 'joe@contact.de',
    'phone'      => '+0172222222'
];
$query = (new Query($this->pdo))
    ->update(
        'users',
        [
            'first_name' => ':first_name',
            'last_name'  => ':last_name',
            'email'      => ':email',
            'phone'      => ':phone'
        ],
        4
    )
    ->params($data)
    ->execute();
```
#### delete
```php
$query = (new Query($this->pdo))->delete('users', 2);
            
$query1 = (new Query($this->pdo))->delete('users')->where('id = :id')->params(['id' => 12]);
```
build the query below
```
DELETE FROM users WHERE (id = :id)
```

delete with ->execute()
```php
(new Query($this->pdo))->delete('users', 2)->execute();
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
#### paginate
```php
    $paginate = (new Query($this->pdo))
        ->from('users', 'u')
        ->into(Demo::class)
        ->paginate(5, 1);
            
    $paginate->getNbPages();
    $paginate->haveToPaginate();
    $paginate->hasPreviousPage();
    $paginate->getPreviousPage();
    $paginate->hasNextPage();
    $paginate->getNextPage();
    $paginate->getCurrentPageOffsetStart();
    $paginate->getCurrentPageOffsetEnd();
    $paginate->getIterator(); // return collections of objects
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
var_dump($demo1 instanceof Demo::class); // TRUE
var_dump($demo2 instanceof Demo::class); // TRUE
```
## Unit Test

We use 1.3.0

## Versioning

```sh
./vendor/bin/phpunit
```
## Authors

* **Goldoni Fouotsa** - *Initial work*

## License

This project is licensed under the MIT License
