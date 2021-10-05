<?php

namespace GitBalocco\KeyValueList;

use GitBalocco\KeyValueList\Contracts\Definer;
use GitBalocco\KeyValueList\Contracts\KeyValueListable;

/**
 * Class InstantKeyValueList
 * @package GitBalocco\KeyValueList
 */
class InstantKeyValueList extends KeyValueList implements KeyValueListable
{
    /** @var Definer $definer */
    private $definer;

    /**
     * InstantKeyValueList constructor.
     * @param Definer $definer
     */
    public function __construct(Definer $definer)
    {
        $this->definer = $definer;
    }

    /**
     * @return Definer
     */
    public function getDefiner(): Definer
    {
        return $this->definer;
    }
}
