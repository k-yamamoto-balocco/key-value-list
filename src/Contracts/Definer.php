<?php

namespace GitBalocco\KeyValueList\Contracts;

/**
 * Interface Definer
 * @package GitBalocco\KeyValueList\Contracts
 */
interface Definer
{
    /**
     * @return array
     */
    public function definition(): array;
}
