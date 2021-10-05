<?php

namespace GitBalocco\KeyValueList\Tests\Traits;

use GitBalocco\KeyValueList\Traits\BehaveAsKeyValueListTrait;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \GitBalocco\KeyValueList\Traits\BehaveAsKeyValueListTrait
 * GitBalocco\KeyValueList\Tests\Traits\BehaveAsKeyValueListTraitTest
 */
class BehaveAsKeyValueListTraitTest extends TestCase
{
    /** @var $testClassName as test target class name */
    protected $testClassName = BehaveAsKeyValueListTrait::class;

    /**
     * @covers ::value
     */
    public function test_value()
    {
        $argumentValue = 'any-string';
        $targetClass = \Mockery::mock($this->testClassName)->makePartial();
        $targetClass->shouldReceive('representativeList->value')
            ->with($argumentValue)
            ->once()
            ->andReturn('return-value');
        $actual = $targetClass->value($argumentValue);
        $this->assertSame('return-value', $actual);
    }

    /**
     * @covers ::all
     */
    public function test_all()
    {
        $targetClass = \Mockery::mock($this->testClassName)->makePartial();

        $targetClass->shouldReceive('representativeList->all')
            ->withNoArgs()
            ->once()
            ->andReturn(['result-of-all']);

        //テスト対象メソッドの実行
        $actual = $targetClass->all();
        $this->assertSame(['result-of-all'], $actual);
    }

    /**
     * @covers ::keys
     */
    public function test_keys()
    {
        $targetClass = \Mockery::mock($this->testClassName)->makePartial();
        $targetClass->shouldReceive('representativeList->keys')
            ->withNoArgs()
            ->once()
            ->andReturn(['result-of-keys']);
        //テスト対象メソッドの実行
        $actual = $targetClass->keys();
        $this->assertSame(['result-of-keys'], $actual);
    }

    /**
     * @covers ::keysAsString
     */
    public function test_keysAsString()
    {
        $targetClass = \Mockery::mock($this->testClassName)->makePartial();
        $targetClass->shouldReceive('representativeList->keysAsString')
            ->withNoArgs()
            ->once()
            ->andReturn(['result-of-keys-as-string']);
        //テスト対象メソッドの実行
        $actual = $targetClass->keysAsString();
        $this->assertSame(['result-of-keys-as-string'], $actual);
    }

    /**
     * @covers ::has
     */
    public function test_has()
    {
        $argumentKey = 'any-key-string';
        $targetClass = \Mockery::mock($this->testClassName)->makePartial();
        $targetClass->shouldReceive('representativeList->has')
            ->with($argumentKey)
            ->once()
            ->andReturn(true);
        //テスト対象メソッドの実行
        $actual = $targetClass->has($argumentKey);
        $this->assertSame(true, $actual);
    }

    /**
     * @covers ::contains
     */
    public function test_contains()
    {
        $argumentValue = 'any-key-value';
        $targetClass = \Mockery::mock($this->testClassName)->makePartial();
        $targetClass->shouldReceive('representativeList->contains')
            ->with($argumentValue)
            ->once()
            ->andReturn(false);
        //テスト対象メソッドの実行
        $actual = $targetClass->contains($argumentValue);
        $this->assertSame(false, $actual);
    }

    /**
     * @covers ::offsetExists
     */
    public function test_offsetExists()
    {
        $argumentOffset = 'any-offset';
        $targetClass = \Mockery::mock($this->testClassName)->makePartial();
        $targetClass->shouldReceive('representativeList->offsetExists')
            ->with($argumentOffset)
            ->once()
            ->andReturn(true);
        //テスト対象メソッドの実行
        $actual = $targetClass->offsetExists($argumentOffset);
        $this->assertSame(true, $actual);
    }

    /**
     * @covers ::offsetGet
     */
    public function test_offsetGet()
    {
        $argumentOffset = 'any-offset';
        $targetClass = \Mockery::mock($this->testClassName)->makePartial();
        $targetClass->shouldReceive('representativeList->offsetGet')
            ->with($argumentOffset)
            ->once()
            ->andReturn('value-of-offset');
        //テスト対象メソッドの実行
        $actual = $targetClass->offsetGet($argumentOffset);
        $this->assertSame('value-of-offset', $actual);
    }

    /**
     * @covers ::offsetSet
     */
    public function test_offsetSet()
    {
        $argumentOffset = 'any-offset';
        $argumentValue = 'any-value';
        $targetClass = \Mockery::mock($this->testClassName)->makePartial();
        $targetClass->shouldReceive('representativeList->offsetSet')
            ->with($argumentOffset, $argumentValue)
            ->once();

        //テスト対象メソッドの実行
        $actual = $targetClass->offsetSet($argumentOffset, $argumentValue);
        $this->assertNull($actual);
    }

    /**
     * @covers ::offsetUnset
     */
    public function test_offsetUnset()
    {
        $argumentOffset = 'any-offset';

        $targetClass = \Mockery::mock($this->testClassName)->makePartial();
        $targetClass->shouldReceive('representativeList->offsetUnset')
            ->with($argumentOffset)
            ->once();

        //テスト対象メソッドの実行
        $actual = $targetClass->offsetUnset($argumentOffset);
        $this->assertNull($actual);
    }

    /**
     * @covers ::getIterator
     */
    public function test_getIterator()
    {
        $targetClass = \Mockery::mock($this->testClassName)->makePartial();
        $targetClass->shouldReceive('representativeList->all')
            ->withNoArgs()
            ->once()
            ->andReturn(['result-of-all']);

        //テスト対象メソッドの実行
        $actual = $targetClass->getIterator();
        $this->assertInstanceOf(\ArrayIterator::class, $actual);
    }

    /**
     *
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        \Mockery::close();
    }


}
