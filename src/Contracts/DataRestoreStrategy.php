<?php

namespace GitBalocco\KeyValueList\Contracts;

/**
 * Interface DataRestoreStrategy
 * @package GitBalocco\KeyValueList\Contracts
 */
interface DataRestoreStrategy
{
    /**
     * @return array
     */
    public function restoreData(): array;

    /**
     * @return Definer
     */
    public function getDefiner(): Definer;
}
