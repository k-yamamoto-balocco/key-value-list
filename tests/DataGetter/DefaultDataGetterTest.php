<?php

namespace Tests\GitBalocco\KeyValueList\DataGetter;

use GitBalocco\KeyValueList\Contracts\DataRestoreStrategy;
use GitBalocco\KeyValueList\Contracts\Definer;
use GitBalocco\KeyValueList\DataGetter\DataGetter;
use GitBalocco\KeyValueList\DataGetter\DefaultDataGetter;
use PHPUnit\Framework\TestCase;

/**
 * Class CacheDataGetterTest
 * @coversDefaultClass \GitBalocco\KeyValueList\DataGetter\DefaultDataGetter
 * @package Tests\GitBalocco\KeyValueList\DataGetter
 */
class DefaultDataGetterTest extends TestCase
{
    protected $testClassName = DefaultDataGetter::class;

    /**
     * @coversNothing
     */
    public function test___construct()
    {
        $stubDefiner = \Mockery::mock(Definer::class);
        $stubDefiner->shouldReceive('definition')->andReturn([1 => 'one', 2 => 'two']);

        $targetClass = new $this->testClassName($stubDefiner);
        $this->assertInstanceOf(DataRestoreStrategy::class, $targetClass);
        $this->assertInstanceOf(DataGetter::class, $targetClass);
    }

    /**
     * @covers ::restoreData
     */
    public function test_restoreData()
    {
        $stubDefiner = \Mockery::mock(Definer::class);
        $stubDefiner->shouldReceive('definition')->andReturn([1 => 'one', 2 => 'two']);

        $targetClass = new $this->testClassName($stubDefiner);
        $actual = $targetClass->restoreData();
        $this->assertSame([1 => 'one', 2 => 'two'], $actual);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        \Mockery::close();
    }
}