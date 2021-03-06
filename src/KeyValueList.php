<?php

namespace GitBalocco\KeyValueList;

use GitBalocco\KeyValueList\Contracts\KeyValueListable;
use GitBalocco\KeyValueList\Traits\DataHolderTrait;
use Traversable;

/**
 * Class KeyValueList
 * @package GitBalocco\KeyValueList
 */
abstract class KeyValueList implements KeyValueListable
{
    use DataHolderTrait;

    /**
     * getIterator
     *
     * @return Traversable
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->getData());
    }

    /**
     * value
     *
     * @param int|string $key array-key
     * @return string
     */
    public function value($key): string
    {
        return $this->offsetGet($key);
    }

    /**
     * offsetGet
     *
     * @param $offset
     * @return mixed
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function offsetGet($offset): mixed
    {
        assert(is_string($offset) || is_int($offset));
        if ($this->offsetExists($offset)) {
            $data = $this->getData();
            return (string)$data[$offset];
        }
        return '';
    }

    /**
     * offsetExists
     *
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        assert(is_string($offset) || is_int($offset));
        return array_key_exists($offset, $this->getData());
    }

    /**
     * keysAsString
     *
     * @return array
     */
    public function keysAsString(): array
    {
        $result = [];
        foreach ($this->keys() as $key) {
            assert(is_string($key) || is_int($key));
            $result[] = (string)$key;
        }
        return $result;
    }

    /**
     * keys
     *
     * @return array
     */
    public function keys(): array
    {
        return array_keys($this->getData());
    }

    /**
     * offsetSet
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        //Do nothing
    }

    /**
     * offsetUnset
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset): void
    {
        //Do nothing
    }

    /**
     * @param int|string $key
     * @return bool
     */
    public function has($key): bool
    {
        return $this->offsetExists($key);
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function contains($value): bool
    {
        return in_array($value, $this->getData(), true);
    }

    /**
     * all
     *
     * @return array
     */
    public function all(): array
    {
        return $this->getData();
    }
}
