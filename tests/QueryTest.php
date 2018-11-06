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
        if (!$this->pdo) {
            $this->pdo = new \PDO('sqlite::memory:', null, null);
            $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_BOTH);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->migrate();
        }
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

    private function migrate()
    {
        $this->pdo->query('CREATE TABLE IF NOT EXISTS users (
          `id` int(10) NOT NULL,
          `first_name` varchar(191) NOT NULL,
          `last_name` varchar(191) NOT NULL,
          `email` varchar(191) NOT NULL,
          `mobile` varchar(191) DEFAULT NULL,
          `phone` varchar(191) DEFAULT NULL,
          `deleted_at` timestamp NULL DEFAULT NULL,
          `created_at` timestamp NULL DEFAULT NULL,
          `updated_at` timestamp NULL DEFAULT NULL
          )');

        $this->pdo->query("INSERT INTO `users` 
        (`id`, `first_name`, `last_name`, `email`, `mobile`, `phone`, `deleted_at`, `created_at`, `updated_at`) VALUES
        (1, 'Rebecca', 'Reynolds', 'admin@contact.de', '+1.707.270.4759',
         '545.717.6134 x32431', NULL, '2018-10-31 02:00:20', '2018-10-31 02:00:20'),
        (2, 'Johan', 'Franecki', 'umcglynn@example.net', '+1-623-845-0323',
         '547-372-5759', NULL, '2018-10-31 02:00:20', '2018-10-31 02:00:20'),
        (3, 'Penelope', 'Carroll', 'hank76@example.org', '359-537-6537 x774', 
        '(547) 806-2053 x621', NULL, '2018-10-31 02:00:20', '2018-10-31 02:00:20'),
        (4, 'Lorine', 'Parker', 'lwalker@example.com', '+1-518-446-3713',
         '373.333.9666 x383', NULL, '2018-10-31 02:00:20', '2018-10-31 02:00:20'),
        (5, 'Eda', 'Koepp', 'schamberger.terrell@example.net', '+13953416930',
         '820.463.1400 x050', NULL, '2018-10-31 02:00:20', '2018-10-31 02:00:20'),
        (6, 'Amara', 'Cummings', 'neil.lind@example.org', '1-425-658-5239 x922',
         '1-927-331-0622', NULL, '2018-10-31 02:00:20', '2018-10-31 02:00:20'),
        (7, 'Easton', 'Mitchell', 'swillms@example.com', '715-623-0986',
         '257-409-0124 x851', NULL, '2018-10-31 02:00:20', '2018-10-31 02:00:20'),
        (8, 'Miracle', 'Schmitt', 'rschmidt@example.net', '928.482.5563',
         '+1.250.579.2466', NULL, '2018-10-31 02:00:20', '2018-10-31 02:00:20'),
        (9, 'Savannah', 'Kuvalis', 'wava.hyatt@example.com', '454-770-8595 x55454', 
        '763-266-7479 x30526', NULL, '2018-10-31 02:00:20', '2018-10-31 02:00:20'),
        (10, 'Owen', 'Cruickshank', 'amely03@example.net', '302.734.6419',
         '786.634.5000 x297', NULL, '2018-10-31 02:00:20', '2018-10-31 02:00:20'),
        (11, 'Jazmin', 'Friesen', 'xfranecki@example.org', '1-691-260-0535',
         '(221) 612-9008 x256', NULL, '2018-10-31 02:00:20', '2018-10-31 02:00:20')");
    }
}
