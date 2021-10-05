<?php

namespace GitBalocco\KeyValueList;

use GitBalocco\KeyValueList\Contracts\ArrayFilterInterface;
use GitBalocco\KeyValueList\Contracts\HasDefiner;
use GitBalocco\KeyValueList\Contracts\KeyValueListable;
use GitBalocco\KeyValueList\Definer\ArrayDefiner;
use GitBalocco\KeyValueList\Traits\DataHolderTrait;

/**
 * Class Classification
 * @package GitBalocco\KeyValueList
 */
abstract class Classification implements HasDefiner
{
    use DataHolderTrait;

    /**
     * 実装クラスに、目的に応じたリストを提供するゲッタを作成する際に利用することを想定したメソッド。
     * @param string|int $valueColIndex
     * @param ArrayFilterInterface $filter
     * @return KeyValueListable
     */
    protected function filteredListOf($valueColIndex, ArrayFilterInterface $filter): KeyValueListable
    {
        //$this->filteredClassification() の結果返ってくるオブジェクトはInstantClassification。
        //InstantClassificationはClassificationをextendしているため、protected メソッドであるが呼び出せる。
        return $this->filteredClassification($filter)->listOf($valueColIndex);
    }

    /**
     * @param ArrayFilterInterface $filter
     * @return InstantClassification
     */
    protected function filteredClassification(ArrayFilterInterface $filter): InstantClassification
    {
        $filtered = array_filter($this->getData(), [$filter, 'arrayFilter']);
        $definer = new ArrayDefiner($filtered);
        return new InstantClassification($definer, $this->getIdentityIndex());
    }

    /**
     * @return string|int
     * 行を特定するための情報を持つキーの値を返す。
     * 連想配列の場合文字列、添字配列の場合数字。
     */
    abstract protected function getIdentityIndex();

    /**
     * 実装クラスに、目的に応じたリストを提供するゲッタを作成する際に利用することを想定したメソッド。
     * @param string|int $valueColIndex
     * @return KeyValueListable
     */
    protected function listOf($valueColIndex): KeyValueListable
    {
        $definer = new ArrayDefiner(array_column($this->getData(), $valueColIndex, $this->getIdentityIndex()));
        return new InstantKeyValueList($definer);
    }

    /**
     * @param string|int $valueColIndex
     * @param string|int $identity
     * @return mixed
     */
    protected function valueOf($valueColIndex, $identity)
    {
        $row = $this->findRow($identity);
        if (array_key_exists($valueColIndex, $row)) {
            return $row[$valueColIndex];
        }
    }

    /**
     * @param string|int $identity
     * @return array
     */
    protected function findRow($identity): array
    {
        $data = $this->getData();

        $arrayKey = array_search($identity, array_column($data, $this->getIdentityIndex()));

        if ($arrayKey !== false) {
            return $data[$arrayKey];
        }
        return [];
    }
}
