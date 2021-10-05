<?php

namespace GitBalocco\KeyValueList\Contracts;

/**
 * DatabaseRepository
 *
 * @package GitBalocco\KeyValueList\Contracts
 */
interface DatabaseRepository
{
    /**
     * データベースからSELECTした結果を返却する。
     * 返却されるデータは2次元配列なければならない。
     * 1行に相当するデータの構造は、配列、もしくはArrayAccessインターフェースを実装していなければならない。
     * stdClassのオブジェクト等はNGであるため、実装時は留意すること。
     * @return array
     */
    public function select(): array;
}
