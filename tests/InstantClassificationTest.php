<?php

namespace GitBalocco\KeyValueList\Tests;

use GitBalocco\KeyValueList\Classification;
use GitBalocco\KeyValueList\Contracts\Definer;
use GitBalocco\KeyValueList\Contracts\HasDefiner;
use GitBalocco\KeyValueList\InstantClassification;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \GitBalocco\KeyValueList\InstantClassification
 * GitBalocco\KeyValueList\Tests\InstantClassificationTest
 */
class InstantClassificationTest extends TestCase
{
    /** @var $testClassName as test target class name */
    protected $testClassName = InstantClassification::class;

    /**
     * @covers ::__construct
     */
    public function test___construct()
    {
        $stubDefiner = \Mockery::mock(Definer::class);
        $targetClass = new $this->testClassName($stubDefiner, 'key-col-index');
        $this->assertInstanceOf(Classification::class, $targetClass);
        $this->assertInstanceOf(HasDefiner::class, $targetClass);
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

    /**
     * @covers ::getIdentityIndex
     * @depends test___construct
     * @param $depends
     */
    public function test_getIdentityIndex($depends)
    {

        $targetClass = $depends[0];

        $actual = \Closure::bind(
            function () use ($targetClass) {
                //テスト対象メソッドの実行
                return $targetClass->getIdentityIndex();
            },
            $this,
            $targetClass
        )->__invoke();

        //assertions
        $this->assertSame('key-col-index', $actual);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        \Mockery::close();
    }


}
