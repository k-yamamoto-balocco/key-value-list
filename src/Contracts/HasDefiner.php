<?php

namespace GitBalocco\KeyValueList\Contracts;

/**
 * Interface HasDefiner
 * @package GitBalocco\KeyValueList\Contracts
 */
interface HasDefiner
{
    /**
     * @return Definer
     */
    public function getDefiner(): Definer;
}
