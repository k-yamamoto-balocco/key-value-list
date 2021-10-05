<?php

namespace GitBalocco\KeyValueList\Traits;

use GitBalocco\KeyValueList\Contracts\CacheRepository;
use GitBalocco\KeyValueList\Driver\CacheRepository\LaravelCacheRepository;

/**
 * Class CacheWithLaravelTrait
 * @package GitBalocco\KeyValueList\Traits
 */
trait CacheWithLaravelTrait
{
    /**
     * @return CacheRepository
     */
    public function getCacheRepository(): CacheRepository
    {
        return new LaravelCacheRepository(static::class . '-cache');
    }
}
