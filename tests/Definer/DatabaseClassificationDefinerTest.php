<?php

namespace Tests\GitBalocco\KeyValueList\Definer;

use GitBalocco\KeyValueList\Contracts\DatabaseRepository;
use GitBalocco\KeyValueList\Contracts\Definer;
use GitBalocco\KeyValueList\Definer\DatabaseClassificationDefiner;
use GitBalocco\KeyValueList\Driver\DatabaseRepository\RawSqlRepository;
use PHPUnit\Framework\TestCase;

/**
 * Class SqlDefinerTest
 * @package Tests\GitBalocco\KeyValueList\DatabaseClassificationDefiner
 * @coversDefaultClass \GitBalocco\KeyValueList\Definer\DatabaseClassificationDefiner
 */
class DatabaseClassificationDefinerTest extends TestCase
{
    protected $testClassName = DatabaseClassificationDefiner::class;

    /**
     * @covers ::__construct
     */
    public function test___construct()
    {
        $mockDatabaseRepo = \Mockery::mock(RawSqlRepository::class);
        $targetClass = new $this->testClassName($mockDatabaseRepo);
        $this->assertInstanceOf(Definer::class, $targetClass);
        return $targetClass;
    }

    /**
     * @covers ::definition
     */
    public function test_definition()
    {
        $mockDatabaseRepo = \Mockery::mock(DatabaseRepository::class);
        $mockDatabaseRepo->shouldReceive('select')->withNoArgs()->andReturn(
            [
                0 => [0 => 'result', 1 => 'of', 2 => 'query']
            ]
        );

        $targetClass = new $this->testClassName($mockDatabaseRepo);

        $actual = $targetClass->definition();

        $this->assertSame([0 => [0 => 'result', 1 => 'of', 2 => 'query']], $actual);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        \Mockery::close();
    }
}