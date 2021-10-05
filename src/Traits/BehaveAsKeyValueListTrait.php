<?php

namespace GitBalocco\KeyValueList\Traits;

use ArrayIterator;

/**
 * Trait BehaveAsKeyValueListTrait
 * BehaveAsKeyValueList を使用するClassificationが利用するトレイト
 * @package GitBalocco\KeyValueList\Traits
 */
trait BehaveAsKeyValueListTrait
{
    /**
     * @param $key
     * @return string
     */
    public function value($key): string
    {
        return $this->representativeList()->value($key);
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->representativeList()->all();
    }

    /**
     * @return array
     */
    public function keys(): array
    {
        return $this->representativeList()->keys();
    }

    /**
     * @return array
     */
    public function keysAsString(): array
    {
        return $this->representativeList()->keysAsString();
    }

    /**
     * @param $key
     * @return bool
     */
    public function has($key): bool
    {
        return $this->representativeList()->has($key);
    }

    /**
     * @param $value
     * @return bool
     */
    public function contains($value): bool
    {
        return $this->representativeList()->contains($value);
    }

    /**
     * @param $offset
     * @return mixed
     */
    public function offsetExists($offset)
    {
        return $this->representativeList()->offsetExists($offset);
    }

    /**
     * @param $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->representativeList()->offsetGet($offset);
    }

    /**
     * @param $offset
     * @param $value
     * @return mixed
     */
    public function offsetSet($offset, $value)
    {
        $this->representativeList()->offsetSet($offset, $value);
    }

    /**
     * @param $offset
     * @return mixed
     */
    public function offsetUnset($offset)
    {
        $this->representativeList()->offsetUnset($offset);
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->representativeList()->all());
    }
}
