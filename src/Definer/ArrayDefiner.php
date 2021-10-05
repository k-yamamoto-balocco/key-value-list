<?php

namespace GitBalocco\KeyValueList\Definer;

use GitBalocco\KeyValueList\Contracts\Definer;

/**
 * Class ArrayDefiner
 *
 * @package GitBalocco\KeyValueList\Definer
 */
class ArrayDefiner implements Definer
{
    /**
     * @var array $data
     */
    private $data;

    /**
     * ArrayDefiner constructor.
     *
     * @param array $array
     */
    public function __construct(array $array)
    {
        $this->data = $array;
    }

    /**
     * definition
     *
     * @return array
     */
    public function definition(): array
    {
        return $this->data;
    }
}
