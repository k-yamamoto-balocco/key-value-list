<?php

namespace GitBalocco\KeyValueList\Driver\DatabaseRepository;

use GitBalocco\KeyValueList\Contracts\DatabaseRepository;
use Illuminate\Database\Eloquent\Builder;

class EloquentBuilderRepository implements DatabaseRepository
{
    /**
     * @var Builder $builder
     */
    private $builder;

    /**
     * EloquentBuilderRepository constructor.
     * @param Builder $builder
     */
    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * @return array
     * @psalm-suppress PossiblyInvalidMethodCall Eloquentの返値が曖昧になっているため
     */
    public function select(): array
    {
        return $this->builder->get()->toArray();
    }
}
