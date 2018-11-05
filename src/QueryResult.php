<?php

namespace Goldoni\Builder;

/**
 * Class QueryResult.
 */
class QueryResult implements \ArrayAccess, \Iterator, \Countable
{
    /**
     * @var array
     */
    private $records;

    /**
     * @var int
     */
    private $index = 0;
    /**
     * @var null|string
     */
    private $entity;

    /**
     * The cache of studly-cased words.
     *
     * @var array
     */
    protected static $hydrateCache = [];

    /**
     * QueryResult constructor.
     *
     * @param array       $records
     * @param null|string $entity
     */
    public function __construct(array $records, ?string $entity = null)
    {
        $this->records = $records;
        $this->entity = $entity;
    }

    public function get(int $index)
    {
        if ($this->entity) {
            if (isset(static::$hydrateCache[$index])) {
                return static::$hydrateCache[$index];
            }

            return static::$hydrateCache[$index] = Builder::hydrate($this->records[$index], $this->entity);
        }

        return $this->entity;
    }

    /**
     * Return the current element.
     *
     * @see  https://php.net/manual/en/iterator.current.php
     *
     * @return mixed can return any type
     *
     * @since 5.0.0
     */
    public function current()
    {
        return $this->get($this->index);
    }

    /**
     * Move forward to next element.
     *
     * @see  https://php.net/manual/en/iterator.next.php
     * @since 5.0.0
     */
    public function next(): void
    {
        ++$this->index;
    }

    /**
     * Return the key of the current element.
     *
     * @see  https://php.net/manual/en/iterator.key.php
     *
     * @return mixed scalar on success, or null on failure
     *
     * @since 5.0.0
     */
    public function key()
    {
        return $this->index;
    }

    /**
     * Checks if current position is valid.
     *
     * @see  https://php.net/manual/en/iterator.valid.php
     *
     * @return bool The return value will be casted to boolean and then evaluated.
     *              Returns true on success or false on failure.
     *
     * @since 5.0.0
     */
    public function valid()
    {
        return isset($this->records[$this->index]);
    }

    /**
     * Rewind the Iterator to the first element.
     *
     * @see  https://php.net/manual/en/iterator.rewind.php
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->index = 0;
    }

    /**
     * Whether a offset exists.
     *
     * @see  https://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     *
     * @return bool true on success or false on failure.
     *              </p>
     *              <p>
     *              The return value will be casted to boolean if non-boolean was returned.
     *
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return isset($this->records[$offset]);
    }

    /**
     * Offset to retrieve.
     *
     * @see  https://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset <p>
     *                      The offset to retrieve.
     *                      </p>
     *
     * @return mixed can return all value types
     *
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * Offset to set.
     *
     * @see  https://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset <p>
     *                      The offset to assign the value to.
     *                      </p>
     * @param mixed $value  <p>
     *                      The value to set.
     *                      </p>
     *
     * @throws \Exception
     *
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        throw  new \Exception("Can't alter records");
    }

    /**
     * Offset to unset.
     *
     * @see  https://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $offset <p>
     *                      The offset to unset.
     *                      </p>
     *
     * @throws \Exception
     *
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        throw  new \Exception("Can't alter records");
    }

    /**
     * Count elements of an object.
     *
     * @see  https://php.net/manual/en/countable.count.php
     *
     * @return int The custom count as an integer.
     *             </p>
     *             <p>
     *             The return value is cast to an integer.
     *
     * @since 5.1.0
     */
    public function count()
    {
        return \count($this->records);
    }
}
