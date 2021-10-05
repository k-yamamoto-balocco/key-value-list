<?php

namespace GitBalocco\KeyValueList\Contracts;

/**
 * Interface ShouldCache
 * @package GitBalocco\KeyValueList\Contracts
 */
interface ShouldCache
{
    /**
     * @return CacheRepository
     */
    public function getCacheRepository(): CacheRepository;
}
