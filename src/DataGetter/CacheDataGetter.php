<?php

namespace GitBalocco\KeyValueList\DataGetter;

use GitBalocco\KeyValueList\Contracts\CacheRepository;
use GitBalocco\KeyValueList\Contracts\DataRestoreStrategy;
use GitBalocco\KeyValueList\Contracts\Definer;

/**
 * Class CacheDataGetter
 *
 * @package GitBalocco\KeyValueList\DataGetter
 */
class CacheDataGetter extends DataGetter implements DataRestoreStrategy
{
    /**
     * @var CacheRepository $repositor
     */
    private $repository;

    /**
     * CacheDataGetter constructor.
     * @param Definer $definer
     * @param CacheRepository $repository
     */
    public function __construct(Definer $definer, CacheRepository $repository)
    {
        parent::__construct($definer);
        $this->repository = $repository;
    }

    /**
     * @return array
     */
    public function restoreData(): array
    {
        //キャッシュから取得できれば返却
        $cachedData = $this->repository->get();
        if ($cachedData !== []) {
            return $cachedData;
        }

        //Cacheから取得できなかった場合、definition()を呼び出し、結果をCacheに保存してから返却
        $array = $this->getDefiner()->definition();
        $this->repository->store($array);
        return $array;
    }
}
