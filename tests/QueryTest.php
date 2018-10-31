<?php

/**
 * Created by PhpStorm.
 * User: emere
 * Date: 31/10/2018
 * Time: 01:47.
 */

namespace Goldoni\Tests;

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
        $this->pdo = new \PDO('mysql:dbname=goldoni;host=localhost;charset=utf8', 'root');
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
            ->where('first_name = :first_name OR email = :email', 'phone = :phone')
            ->where('mobile = :mobile');

        $this->assertSame('SELECT * FROM users as u WHERE (first_name = :first_name OR email = :email) AND (phone = :phone) AND (mobile = :mobile)', (string) $query);
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
}
