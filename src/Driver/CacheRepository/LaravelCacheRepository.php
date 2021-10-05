<?php

namespace GitBalocco\KeyValueList\Driver\CacheRepository;

use GitBalocco\KeyValueList\Contracts\CacheRepository;

/**
 * Class LaravelCacheRepository
 * LaravelCacheファサードを介してデータをキャッシュする
 * @package GitBalocco\KeyValueList\Driver\CacheRepository
 */
class LaravelCacheRepository implements CacheRepository
{
    /** @var string $cacheKey */
    private $cacheKey;

    /**
     * LaravelCacheRepository constructor.
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->cacheKey = $key;
    }

    /**
     * @return array
     * @psalm-suppress MixedAssignment
     */
    public function get(): array
    {
        $cachedData = \Illuminate\Support\Facades\Cache::get($this->cacheKey);
        if (is_array($cachedData)) {
            return $cachedData;
        }
        return [];
    }

    /**
     * @param array $data
     * @return mixed|void
     */
    public function store(array $data)
    {
        \Illuminate\Support\Facades\Cache::put($this->cacheKey, $data);
    }

    /**
     * @return mixed|void
     */
    public function remove()
    {
        \Illuminate\Support\Facades\Cache::forget($this->cacheKey);
    }
}
