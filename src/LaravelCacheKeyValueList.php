<?php

namespace GitBalocco\KeyValueList;

use GitBalocco\KeyValueList\Contracts\ShouldCache;
use GitBalocco\KeyValueList\Traits\CacheWithLaravelTrait;

/**
 * Class LaravelCacheKeyValueList
 * @package GitBalocco\KeyValueList
 */
abstract class LaravelCacheKeyValueList extends KeyValueList implements ShouldCache
{
    use CacheWithLaravelTrait;
}
