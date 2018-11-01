<?php

namespace Goldoni\Builder;

/**
 * Class Builder.
 */
class Builder
{
    /**
     * The cache of studly-cased words.
     *
     * @var array
     */
    protected static $studlyCache = [];
    /**
     * The cache of camel-cased words.
     *
     * @var array
     */
    protected static $camelCache = [];

    public static function hydrate(array $item, $object)
    {
        if (\is_string($object)) {
            $instance = new $object();
        } else {
            $instance = $object;
        }

        foreach ($item as $key => $value) {
            $method = 'set' . self::studly($key);

            if (method_exists($instance, $method)) {
                $instance->{$method}($value);
            } else {
                $property = self::camel($key);
                $instance->{$property} = $value;
            }
        }

        return $instance;
    }

    public static function studly($value)
    {
        $key = $value;

        if (isset(static::$studlyCache[$key])) {
            return static::$studlyCache[$key];
        }

        $value = ucwords(str_replace(['-', '_'], ' ', $value));

        return static::$studlyCache[$key] = str_replace(' ', '', $value);
    }

    /**
     * Convert a value to camel case.
     *
     * @param string $value
     *
     * @return string
     */
    public static function camel($value)
    {
        if (isset(static::$camelCache[$value])) {
            return static::$camelCache[$value];
        }

        return static::$camelCache[$value] = lcfirst(static::studly($value));
    }
}
