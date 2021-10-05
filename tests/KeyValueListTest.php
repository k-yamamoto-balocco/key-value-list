<?php

namespace Tests\GitBalocco\KeyValueList;

use GitBalocco\KeyValueList\Contracts\DataRestoreStrategy;
use GitBalocco\KeyValueList\Contracts\Definer;
use GitBalocco\KeyValueList\Contracts\KeyValueListable;
use GitBalocco\KeyValueList\KeyValueList;
use PHPUnit\Framework\TestCase;

/**
 * Class KeyValueListTest
 * @coversDefaultClass \GitBalocco\KeyValueList\KeyValueList
 * @package Tests\GitBalocco\KeyValueList
 */
class KeyValueListTest extends TestCase
{
    /** @var string $testClassName */
    protected $testClassName = KeyValueList::class;

    /**
     * @coversNothing
     */
    public function test___construct()
    {
        $targetClass = \Mockery::mock($this->testClassName);
        $this->assertInstanceOf(KeyValueListable::class, $targetClass);
        return $targetClass;
    }

    /**
     * test_getIterator
     *
     * @covers ::getIterator
     */
    public function test_getIterator()
    {
        $targetClass = \Mockery::mock($this->testClassName)->makePartial()->shouldAllowMockingProtectedMethods();
        $targetClass->shouldReceive('getData')->once()->andReturn([]);
        $actual = $targetClass->getIterator();
        $this->assertInstanceOf(\ArrayIterator::class, $actual);
    }

    /**
     * @covers ::getData
     */
    public function test_getData()
    {
        $mockStrategy = \Mockery::mock(DataRestoreStrategy::class);
        $mockStrategy->shouldReceive('restoreData')->once()->andReturn(['1回だけ呼び出される'], ['2回目は呼ばれない']);

        $targetClass = \Mockery::mock($this->testClassName)->makePartial()->shouldAllowMockingProtectedMethods();
        $targetClass->shouldReceive('getDataRestoreStrategy')->once()->andReturn($mockStrategy);

        $actual1 = $targetClass->getData();
        $this->assertSame(['1回だけ呼び出される'], $actual1);

        $actual2 = $targetClass->getData();
        $this->assertSame(['1回だけ呼び出される'], $actual2);
    }

    /**
     * @covers ::getDataRestoreStrategy
     */
    public function test_getDataRestoreStrategy()
    {
        $mockDefiner = \Mockery::mock(Definer::class);

        $targetClass = \Mockery::mock($this->testClassName)->makePartial()->shouldAllowMockingProtectedMethods();
        $targetClass->shouldReceive('getDefiner')->andReturn($mockDefiner);

        $actual1 = $targetClass->getDataRestoreStrategy();
        $this->assertInstanceOf(DataRestoreStrategy::class, $actual1);

        $actual2 = $targetClass->getDataRestoreStrategy();
        $this->assertInstanceOf(DataRestoreStrategy::class, $actual2);
    }

    /**
     * @covers ::value
     */
    public function test_value(){
        $argument = "any value";
        $targetClass = \Mockery::mock($this->testClassName)->makePartial()->shouldAllowMockingProtectedMethods();
        $targetClass->shouldReceive('offsetGet')->with($argument)->once()->andReturn('return value');
        $actual = $targetClass->value($argument);
        $this->assertSame('return value', $actual);
    }

    /**
     * @covers ::offsetGet
     */
    public function test_offsetGet_True(){
        $argument = 'argument';
        $targetClass = \Mockery::mock($this->testClassName)->makePartial()->shouldAllowMockingProtectedMethods();
        $targetClass->shouldReceive('offsetExists')->with($argument)->once()->andReturnTrue();
        $targetClass->shouldReceive('getData')->once()->andReturn(['hoge' => 'piyo', $argument => 'return value']);
        $actual = $targetClass->offsetGet($argument);
        $this->assertSame('return value', $actual);
    }

    /**
     * @covers ::offsetGet
     */
    public function test_offsetGet_TrueCastString(){
        $argument = 'argument2';
        $targetClass = \Mockery::mock($this->testClassName)->makePartial()->shouldAllowMockingProtectedMethods();
        $targetClass->shouldReceive('offsetExists')->with($argument)->once()->andReturnTrue();
        $targetClass->shouldReceive('getData')->once()->andReturn(['hoge' => 'piyo', $argument => 101010]);
        $actual = $targetClass->offsetGet($argument);
        $this->assertSame('101010',$actual);
        $this->assertIsString($actual);
    }


    /**
     * @covers ::offsetGet
     */
    public function test_offsetGet_False(){
        $argument = 'argument';
        $targetClass = \Mockery::mock($this->testClassName)->makePartial()->shouldAllowMockingProtectedMethods();
        $targetClass->shouldReceive('offsetExists')->with($argument)->once()->andReturnFalse();
        $actual = $targetClass->offsetGet($argument);
        $this->assertSame('', $actual);
    }

    /**
     * @covers ::offsetExists
     */
    public function test_offsetExists_True(){
        $argument = 'argument';
        $targetClass = \Mockery::mock($this->testClassName)->makePartial()->shouldAllowMockingProtectedMethods();
        $targetClass->shouldReceive('getData')->once()->andReturn(['hoge' => 'piyo', $argument => 'exists']);
        $actual = $targetClass->offsetExists($argument);
        $this->assertTrue($actual);
    }

    /**
     * @covers ::offsetExists
     */
    public function test_offsetExists_False(){
        $argument = 'array-key-not-exist';
        $targetClass = \Mockery::mock($this->testClassName)->makePartial()->shouldAllowMockingProtectedMethods();
        $targetClass->shouldReceive('getData')->once()->andReturn(['hoge' => 'piyo']);
        $actual = $targetClass->offsetExists($argument);
        $this->assertFalse($actual);
    }

    /**
     * @covers ::all
     */
    public function test_all(){
        $targetClass = \Mockery::mock($this->testClassName)->makePartial()->shouldAllowMockingProtectedMethods();
        $targetClass->shouldReceive('getData')->once()->andReturn([1 => 'a']);
        $actual = $targetClass->all();
        $this->assertSame([1 => 'a'], $actual);
    }

    /**
     * @covers ::keysAsString
     */
    public function test_keysAsString()
    {
        $targetClass = \Mockery::mock($this->testClassName)->makePartial()->shouldAllowMockingProtectedMethods();
        $targetClass->shouldReceive('keys')->once()->andReturn([0, 1, 2, 3, 4, 5, 6]);
        $actual = $targetClass->keysAsString();
        $this->assertSame(['0', '1', '2', '3', '4', '5', '6'], $actual);
    }


    /**
     * @covers ::keys
     */
    public function test_keys()
    {
        $targetClass = \Mockery::mock($this->testClassName)->makePartial()->shouldAllowMockingProtectedMethods();
        $targetClass->shouldReceive('getData')->once()->andReturn(
            [
                0 => 'zero',
                1 => 'one',
                2 => 'two'
            ]
        );
        $actual = $targetClass->keys();
        $this->assertSame([0, 1, 2], $actual);
    }

    /**
     * @covers ::offsetSet
     */
    public function test_offsetSet()
    {
        $targetClass = \Mockery::mock($this->testClassName)->makePartial()->shouldAllowMockingProtectedMethods();
        $actual = $targetClass->offsetSet('offset', 'value');
        $this->assertNull($actual);
    }

    /**
     * @covers ::offsetUnset
     */
    public function test_offsetUnset()
    {
        $targetClass = \Mockery::mock($this->testClassName)->makePartial()->shouldAllowMockingProtectedMethods();
        $actual = $targetClass->offsetUnset('offset');
        $this->assertNull($actual);
    }

    /**
     * @covers ::has
     */
    public function test_has()
    {
        $targetClass = \Mockery::mock($this->testClassName)->makePartial()->shouldAllowMockingProtectedMethods();
        $targetClass->shouldReceive('offsetExists')->with('key')->once()->andReturn(true);
        $actual = $targetClass->has('key');
        $this->assertTrue($actual);
    }

    /**
     * @covers ::contains
     */
    public function test_contains(){
        $list = [
            1 => 'aaa',
            2 => 'bbb',
            3 => true,
            4=> ''
        ];
        $targetClass = \Mockery::mock($this->testClassName)->makePartial()->shouldAllowMockingProtectedMethods();
        $targetClass->shouldReceive('getData')->andReturn($list);
        $this->assertTrue($targetClass->contains('aaa'));
        $this->assertTrue($targetClass->contains('bbb'));
        $this->assertTrue($targetClass->contains(true));
        $this->assertTrue($targetClass->contains(''));

        $this->assertFalse($targetClass->contains('ccc'));
        $this->assertFalse($targetClass->contains(1));
        $this->assertFalse($targetClass->contains('1'));
        $this->assertFalse($targetClass->contains(false));
        $this->assertFalse($targetClass->contains('0'));
        $this->assertFalse($targetClass->contains(0));
        $this->assertFalse($targetClass->contains('true'));
        $this->assertFalse($targetClass->contains('false'));
        $this->assertFalse($targetClass->contains(null));
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        \Mockery::close();
    }
}