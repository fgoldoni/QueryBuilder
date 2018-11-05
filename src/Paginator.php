<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 05.11.18
 * Time: 00:46.
 */

namespace Goldoni\Builder;

use Pagerfanta\Adapter\AdapterInterface;

/**
 * Class Paginator.
 */
class Paginator implements AdapterInterface
{
    /**
     * @var \Goldoni\Builder\Query
     */
    private $query;

    /**
     * Paginator constructor.
     *
     * @param \Goldoni\Builder\Query $query
     */
    public function __construct(Query $query)
    {
        $this->query = $query;
    }

    /**
     * Returns the number of results.
     *
     * @throws \Exception
     *
     * @return int the number of results
     */
    public function getNbResults()
    {
        return $this->query->count();
    }

    /**
     * Returns an slice of the results.
     *
     * @param int $offset the offset
     * @param int $length the length
     *
     * @return array|\Traversable the slice
     */
    public function getSlice($offset, $length)
    {
        return $this->query->limit($length, $offset)->fetchAll();
    }
}
