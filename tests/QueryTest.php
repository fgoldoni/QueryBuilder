<?php

/**
 * Created by PhpStorm.
 * User: emere
 * Date: 31/10/2018
 * Time: 01:47.
 */

namespace Goldoni\Tests;

use Goldoni\Builder\Entities\Demo;
use Goldoni\Builder\Query;
use PHPUnit\Framework\TestCase;

/**
 * Class BuilderTest.
 */
class QueryTest extends TestCase
{
    private $pdo;

    public function setUp()
    {
        $this->pdo = new \PDO('mysql:dbname=goldoni;host=127.0.0.1;charset=utf8', 'root', 'root');
        $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_BOTH);
    }

    public function testSimpleQuery()
    {
        $query = (new Query())->from('users')->select('first_name');
        $this->assertSame('SELECT first_name FROM users', (string) $query);
    }

    public function testWhereQuery()
    {
        $query = (new Query($this->pdo))
            ->from('users', 'u')
            ->where('first_name = :first_name OR email = :email', 'phone = :phone');

        $this->assertSame(
            'SELECT * FROM users as u WHERE (first_name = :first_name OR email = :email) AND (phone = :phone)',
            (string) $query
        );

        $query = (new Query($this->pdo))
            ->from('users', 'u')
            ->where('first_name = :first_name OR email = :email')
            ->where('mobile = :mobile');

        $this->assertSame(
            'SELECT * FROM users as u WHERE (first_name = :first_name OR email = :email) AND (mobile = :mobile)',
            (string) $query
        );
    }

    public function testFetchAllQuery()
    {
        $users = (new Query($this->pdo))
            ->from('users', 'u')
            ->count();

        $this->assertSame(11, $users);

        $users = (new Query($this->pdo))
            ->from('users', 'u')
            ->where('u.id < :number')
            ->params([
                'number' => 5
            ])
            ->count();

        $this->assertSame(4, $users);
    }

    public function testHydrateQuery()
    {
        $users = (new Query($this->pdo))
            ->from('users', 'u')
            ->into(Demo::class)
            ->fetchAll();

        $this->assertSame('Rebecca', $users[0]->firstName);
    }

    public function testLazyHydrateQuery()
    {
        $users = (new Query($this->pdo))
            ->from('users', 'u')
            ->into(Demo::class)
            ->fetchAll();
        $user1 = $users[0];
        $user2 = $users[0];

        $this->assertSame($user1, $user2);
    }

    public function testLimitQuery()
    {
        $query = (new Query($this->pdo))
            ->from('users', 'u')
            ->where('first_name = :first_name OR email = :email')
            ->limit(5);

        $this->assertSame(
            'SELECT * FROM users as u WHERE (first_name = :first_name OR email = :email) LIMIT 0, 5',
            (string) $query
        );
    }

    public function testOrderByQuery()
    {
        $query = (new Query($this->pdo))
            ->from('users', 'u')
            ->orderBy('u.id', 'DESC')
            ->limit(5);

        $this->assertSame(
            'SELECT * FROM users as u ORDER BY u.id DESC LIMIT 0, 5',
            (string) $query
        );
    }

    public function testGroupByQuery()
    {
        $query = (new Query())
            ->select('u.first_name', 'COUNT(id)')
            ->from('users', 'u')
            ->groupBy('u.updated_at');

        $this->assertSame(
            'SELECT u.first_name, COUNT(id) FROM users as u GROUP BY u.updated_at',
            (string) $query
        );
    }

    public function testJoinsQuery()
    {
        $query = (new Query())
            ->from('users', 'u')
            ->select('first_name')
            ->join('posts as p', 'u.id = p.user_id');

        $this->assertSame(
            'SELECT first_name FROM users as u LEFT JOIN posts as p ON u.id = p.user_id',
            (string) $query
        );

        $query = (new Query())
            ->from('users', 'u')
            ->select('first_name')
            ->join('posts as p2', 'u.id = p2.user_id', 'inner');

        $this->assertSame(
            'SELECT first_name FROM users as u INNER JOIN posts as p2 ON u.id = p2.user_id',
            (string) $query
        );
    }

    public function testFindQuery()
    {
        $user = (new Query($this->pdo))
            ->from('users', 'u')
            ->where('id = :id')
            ->into(Demo::class)
            ->params(['id' => 1])
            ->fetch();

        $this->assertSame('Rebecca', $user->firstName);
        $this->assertSame(Demo::class, \get_class($user));
    }

    public function testFindOrFailQuery()
    {
        $user = (new Query($this->pdo))
            ->from('users', 'u')
            ->where('id = :id')
            ->into(Demo::class)
            ->params(['id' => 100])
            ->fetch();

        $this->assertFalse($user);
    }

    public function testInsertQuery()
    {
        $query = (new Query($this->pdo))
            ->insert(
                'users',
                [
                    'first_name' => ':first_name',
                    'last_name'  => ':last_name',
                    'email'      => ':email',
                    'phone'      => ':phone'
                ]
            );

        $this->assertSame(
            'INSERT INTO users (first_name, last_name, email, phone) VALUES (:first_name, :last_name, :email, :phone)',
            (string) $query
        );

        $user = (new Query($this->pdo))
            ->insert(
                'users',
                [
                    'first_name' => ':first_name',
                    'last_name'  => ':last_name',
                    'email'      => ':email',
                    'phone'      => ':phone',
                ]
            )
            ->params(
                [
                    'first_name' => 'Admin',
                    'last_name'  => 'SG',
                    'email'      => 'test@contact.de',
                    'mobile'     => '+1-623-845-0323',
                    'phone'      => '+1-623-845-0323',
                ],
                false
            );
    }

    public function testPaginateQuery()
    {
        $paginate = (new Query($this->pdo))
            ->from('users', 'u')
            ->into(Demo::class)
            ->paginate(5, 1);

        $this->assertSame(3, $paginate->getNbPages());
        $this->assertSame(1, $paginate->getCurrentPageOffsetStart());
        $this->assertSame(5, $paginate->getCurrentPageOffsetEnd());
        $this->assertSame(5, \count($paginate->getIterator()));

        $paginate = (new Query($this->pdo))
            ->from('users', 'u')
            ->into(Demo::class)
            ->paginate(5, 2);

        $this->assertSame(3, $paginate->getNbPages());
        $this->assertSame(6, $paginate->getCurrentPageOffsetStart());
        $this->assertSame(10, $paginate->getCurrentPageOffsetEnd());
        $this->assertSame(5, \count($paginate->getIterator()));
    }
}
