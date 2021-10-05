<?php

namespace GitBalocco\KeyValueList\DataGetter;

use GitBalocco\KeyValueList\Contracts\DataRestoreStrategy;

/**
 * Class DefaultDataGetter
 *
 * @package GitBalocco\KeyValueList\DataGetter
 */
class DefaultDataGetter extends DataGetter implements DataRestoreStrategy
{
    /**
     * restoreData
     *
     * @return array
     */
    public function restoreData(): array
    {
        return $this->getDefiner()->definition();
    }
}
