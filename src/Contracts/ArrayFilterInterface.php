<?php

namespace GitBalocco\KeyValueList\Contracts;

/**
 * Interface ArrayFilterInterface
 * @package GitBalocco\KeyValueList\Contracts
 */
interface ArrayFilterInterface
{
    /**
     * @param array $row
     * @return bool
     */
    public function arrayFilter(array $row): bool;
}
