<?php

namespace GitBalocco\KeyValueList;

use GitBalocco\KeyValueList\Contracts\ArrayFilterInterface;
use GitBalocco\KeyValueList\Contracts\KeyValueListable;
use GitBalocco\KeyValueList\Contracts\ShouldCache;
use GitBalocco\KeyValueList\Traits\CacheWithLaravelTrait;

/**
 * Class LaravelCacheClassification
 * @package GitBalocco\KeyValueList
 * @method KeyValueListable filteredListOf($valueColIndex, ArrayFilterInterface $filter)
 * @method KeyValueListable listOf($valueColIndex)
 * @method InstantClassification filteredClassification(ArrayFilterInterface $filter)
 */
abstract class LaravelCacheClassification extends Classification implements ShouldCache
{
    use CacheWithLaravelTrait;
}
