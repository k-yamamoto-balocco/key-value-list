<?php

namespace GitBalocco\KeyValueList\Contracts;

/**
 * Interface BehaveAsKeyValueList
 * @package GitBalocco\KeyValueList\Contracts
 */
interface BehaveAsKeyValueList extends KeyValueListable
{
    /**
     * @return KeyValueListable
     */
    public function representativeList(): KeyValueListable;
}
