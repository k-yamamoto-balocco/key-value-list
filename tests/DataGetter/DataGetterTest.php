<?php

namespace Tests\GitBalocco\KeyValueList\DataGetter;

use GitBalocco\KeyValueList\Contracts\DataRestoreStrategy;
use GitBalocco\KeyValueList\Contracts\Definer;
use GitBalocco\KeyValueList\DataGetter\DataGetter;
use PHPUnit\Framework\TestCase;

/**
 * Class CacheDataGetterTest
 * @coversDefaultClass \GitBalocco\KeyValueList\DataGetter\DataGetter
 * @package Tests\GitBalocco\KeyValueList\DataGetter
 */
class DataGetterTest extends TestCase
{
    protected $testClassName = DataGetter::class;

    /**
     * @covers ::__construct
     */
    public function test___construct()
    {
        $stubDefiner = \Mockery::mock(Definer::class);
        $stubDefiner->shouldReceive('definition')->andReturn([1 => 'one', 2 => 'two']);

        $targetClass = \Mockery::mock($this->testClassName, [$stubDefiner]);
        $this->assertInstanceOf(DataRestoreStrategy::class, $targetClass);
        $this->assertInstanceOf(DataGetter::class, $targetClass);
    }

    /**
     * @covers ::getDefiner
     */
    public function test_getDefiner()
    {
        $stubDefiner = \Mockery::mock(Definer::class);
        $stubDefiner->shouldReceive('definition')->andReturn([1 => 'one', 2 => 'two']);

        $targetClass = \Mockery::mock($this->testClassName, [$stubDefiner])->makePartial();
        $actual = $targetClass->getDefiner();
        $this->assertSame($stubDefiner, $actual);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        \Mockery::close();
    }
}