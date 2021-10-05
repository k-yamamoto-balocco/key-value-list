<?php

namespace GitBalocco\KeyValueList\Traits;

use GitBalocco\KeyValueList\Contracts\DataRestoreStrategy;
use GitBalocco\KeyValueList\DataGetter\DataGetterFactory;

trait DataHolderTrait
{
    /**
     * @var array $data
     */
    private $data = [];
    /**
     * @var DataRestoreStrategy|null $dataRestoreStrategy
     */
    private $dataRestoreStrategy;

    /**
     * getData
     *
     * @return array
     */
    protected function getData(): array
    {
        //プロパティに何かしら入っていればそれを返却して終了
        if ($this->data !== []) {
            return $this->data;
        }
        //何も入っていなければdataに詰め直す
        $this->data = $this->getDataRestoreStrategy()->restoreData();
        return $this->data;
    }

    /**
     * @return DataRestoreStrategy
     */
    protected function getDataRestoreStrategy(): DataRestoreStrategy
    {
        if ($this->dataRestoreStrategy) {
            return $this->dataRestoreStrategy;
        }
        $factory = new DataGetterFactory($this);
        $this->dataRestoreStrategy = $factory->build();
        return $this->dataRestoreStrategy;
    }
}
