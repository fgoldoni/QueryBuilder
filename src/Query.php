<?php

/**
 * Created by PhpStorm.
 * User: Goldoni
 * Date: 31/10/2018
 * Time: 00:53.
 */

namespace Goldoni\Builder;

use PDO;

/**
 * Class Builder.
 */
class Query
{
    private $select;

    private $from;

    private $where = [];

    private $group;

    private $order;

    private $limit;
    /**
     * @var \PDO
     */
    private $pdo;

    private $params;

    /**
     * Query constructor.
     *
     * @param null|\PDO $pdo
     */
    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param string $table
     * @param string $alias
     *
     * @return \Goldoni\Builder\Query
     */
    public function from(string $table, ?string $alias = null): self
    {
        if ($alias) {
            $this->from[$alias] = $table;
        } else {
            $this->from[] = $table;
        }

        return $this;
    }

    /**
     * @param string[] ...$fields
     *
     * @return \Goldoni\Builder\Query
     */
    public function select(string ...$fields): self
    {
        $this->select = $fields;

        return $this;
    }

    public function where(string ...$conditions): self
    {
        $this->where = array_merge($this->where, $conditions);

        return $this;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        $this->select('COUNT(id)');

        return $this->execute()->fetchColumn();
    }

    public function params(array $params): self
    {
        $this->params = $params;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $parts = ['SELECT'];

        if ($this->select) {
            $parts[] = implode(', ', $this->select);
        } else {
            $parts[] = '*';
        }

        $parts[] = 'FROM';
        $parts[] = $this->buildFrom();

        if (!empty($this->where)) {
            $parts[] = 'WHERE';
            $parts[] = '(' . implode(') AND (', $this->where) . ')';
        }

        return implode(' ', $parts);
    }

    private function buildFrom(): string
    {
        $from = [];

        foreach ($this->from as $key => $value) {
            if (\is_string($key)) {
                $from[] = "$value as $key";
            } else {
                $from[] = $value;
            }
        }

        return implode(', ', $from);
    }

    private function execute()
    {
        if ($this->params) {
            $statement = $this->pdo->prepare($this->__toString());
            $statement->execute($this->params);

            return $statement;
        }

        return $this->pdo->query($this->__toString());
    }
}
