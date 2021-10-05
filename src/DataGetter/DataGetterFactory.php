<?php

namespace GitBalocco\KeyValueList\DataGetter;

use GitBalocco\KeyValueList\Contracts\DataRestoreStrategy;
use GitBalocco\KeyValueList\Contracts\HasDefiner;
use GitBalocco\KeyValueList\Contracts\ShouldCache;

/**
 * Class DataGetterFactory
 * @package GitBalocco\KeyValueList\DataGetter
 */
class DataGetterFactory implements \GitBalocco\KeyValueList\Contracts\DataGetterFactory
{
    /** @var HasDefiner $keyValueList */
    private $keyValueList;

    /**
     * DataGetterFactory constructor.
     * @param HasDefiner $keyValueList
     */
    public function __construct(HasDefiner $keyValueList)
    {
        $this->keyValueList = $keyValueList;
    }

    /**
     * factory
     *
     * @return DataRestoreStrategy
     */
    public function build(): DataRestoreStrategy
    {
        $keyValueList = $this->getKeyValueList();
        $definer = $keyValueList->getDefiner();

        //キャッシュ利用のStrategyを優先。
        if (is_a($keyValueList, ShouldCache::class)) {
            return new CacheDataGetter($definer, $keyValueList->getCacheRepository());
        }

        return new DefaultDataGetter($definer);
    }

    /**
     * @return HasDefiner
     */
    private function getKeyValueList(): HasDefiner
    {
        return $this->keyValueList;
    }
}
