<?php

namespace GitBalocco\KeyValueList\Definer;

use GitBalocco\KeyValueList\Contracts\DatabaseRepository;
use GitBalocco\KeyValueList\Contracts\Definer;

/**
 * Class SqlDefiner
 *
 * @package GitBalocco\KeyValueList\Definer
 */
class DatabaseClassificationDefiner implements Definer
{
    /**
     * @var DatabaseRepository $repository
     */
    private $repository;

    /**
     * SqlDefiner constructor.
     *
     * @param DatabaseRepository $repository
     */
    public function __construct(DatabaseRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * definition
     *
     * @return array
     */
    public function definition(): array
    {
        return $this->repository->select();
    }
}
