<?php

namespace Tests\GitBalocco\KeyValueList\Definer;

use GitBalocco\KeyValueList\Contracts\Definer;
use GitBalocco\KeyValueList\Definer\ArrayDefiner;
use PHPUnit\Framework\TestCase;

/**
 * Class ArrayDefinerTest
 * @coversDefaultClass \GitBalocco\KeyValueList\Definer\ArrayDefiner
 * @package Tests\GitBalocco\KeyValueList\Definer
 */
class ArrayDefinerTest extends TestCase
{
    protected $testClassName = ArrayDefiner::class;

    /**
     * @covers ::__construct
     */
    public function test___construct()
    {
        $argument = [1 => 'one', 2 => 'two'];
        $targetClass = new $this->testClassName($argument);
        $this->assertInstanceOf(Definer::class, $targetClass);
        return $targetClass;
    }

    /**
     * @param mixed $targetClass
     * @covers ::definition
     * @depends test___construct
     */
    public function test_definition($targetClass)
    {
        $actual = $targetClass->definition();
        $this->assertSame([1 => 'one', 2 => 'two'], $actual);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        \Mockery::close();
    }
}