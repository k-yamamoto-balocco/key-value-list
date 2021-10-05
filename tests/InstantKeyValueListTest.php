<?php

namespace GitBalocco\KeyValueList\Tests;

use GitBalocco\KeyValueList\Contracts\Definer;
use GitBalocco\KeyValueList\Contracts\KeyValueListable;
use GitBalocco\KeyValueList\InstantKeyValueList;
use GitBalocco\KeyValueList\KeyValueList;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \GitBalocco\KeyValueList\InstantKeyValueList
 * GitBalocco\KeyValueList\Tests\InstantKeyValueListTest
 */
class InstantKeyValueListTest extends TestCase
{
    /** @var $testClassName as test target class name */
    protected $testClassName = InstantKeyValueList::class;

    /**
     * @covers ::__construct
     */
    public function test___construct()
    {
        $stubDefiner = \Mockery::mock(Definer::class);
        $targetClass = new $this->testClassName($stubDefiner);
        $this->assertInstanceOf(KeyValueList::class, $targetClass);
        $this->assertInstanceOf(KeyValueListable::class, $targetClass);
        return [$targetClass, $stubDefiner];
    }

    /**
     * @param mixed $depends
     * @covers ::getDefiner
     * @depends test___construct
     */
    public function test_getDefiner($depends)
    {
        $targetClass = $depends[0];
        $stubDefiner = $depends[1];

        //テスト対象メソッドの実行
        $actual = $targetClass->getDefiner();
        //assertions
        $this->assertSame($stubDefiner, $actual);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        \Mockery::close();
    }

}
