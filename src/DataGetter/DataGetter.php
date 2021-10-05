<?php

namespace GitBalocco\KeyValueList\DataGetter;

use GitBalocco\KeyValueList\Contracts\DataRestoreStrategy;
use GitBalocco\KeyValueList\Contracts\Definer;

/**
 * DataGetter
 *
 * @package GitBalocco\KeyValueList\DataGetter
 */
abstract class DataGetter implements DataRestoreStrategy
{

    /** @var Definer $definer */
    private $definer;

    /**
     * DataGetter constructor.
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
