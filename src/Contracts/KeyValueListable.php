<?php

namespace GitBalocco\KeyValueList\Contracts;

use ArrayAccess;
use IteratorAggregate;

/**
 * Interface KeyValueListable
 * @package GitBalocco\KeyValueList\Contracts
 */
interface KeyValueListable extends IteratorAggregate, ArrayAccess, HasDefiner
{
    /**
     * value
     *
     * @param string | int $key
     * @return string
     */
    public function value($key): string;

    /**
     * @return array
     */
    public function all(): array;

    /**
     * @return array
     */
    public function keys(): array;

    /**
     * @return array
     */
    public function keysAsString(): array;

    /**
     * @param string | int $key
     * @return bool
     */
    public function has($key): bool;

    /**
     * @param mixed $value
     * @return bool
     */
    public function contains($value): bool;
}
