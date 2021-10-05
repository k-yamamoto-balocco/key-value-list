<?php

namespace GitBalocco\KeyValueList\Contracts;

/**
 * Interface DataGetterFactory
 * @package GitBalocco\KeyValueList\Contracts
 */
interface DataGetterFactory
{
    /**
     * @return DataRestoreStrategy
     */
    public function build(): DataRestoreStrategy;
}
