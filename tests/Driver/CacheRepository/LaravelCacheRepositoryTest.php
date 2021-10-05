<?php

namespace GitBalocco\KeyValueList\Tests\Driver\CacheRepository;

use GitBalocco\KeyValueList\Contracts\CacheRepository;
use GitBalocco\KeyValueList\Driver\CacheRepository\LaravelCacheRepository;
use Illuminate\Support\Facades\Cache;
use Orchestra\Testbench\TestCase;

/**
 * @coversDefaultClass \GitBalocco\KeyValueList\Driver\CacheRepository\LaravelCacheRepository
 * GitBalocco\KeyValueList\Tests\Driver\CacheRepository\LaravelCacheRepositoryTest
 */
class LaravelCacheRepositoryTest extends TestCase
{
    /** @var $testClassName as test target class name */
    protected $testClassName = LaravelCacheRepository::class;

    /**
     * @covers ::__construct
     */
    public function test___construct()
    {
        $targetClass = new $this->testClassName('cache-key');
        $this->assertInstanceOf(CacheRepository::class, $targetClass);
    }

    /**
     * @covers ::get
     */
    public function test_get()
    {
        $targetClass = new $this->testClassName('cache-key');
        Cache::shouldReceive('get')->with('cache-key')->once()->andReturn(
            [
                ['cached-data' => 'value1'],
                ['cached-data' => 'value2']
            ]
        );
        $actual = $targetClass->get();
        $this->assertSame(
            [
                ['cached-data' => 'value1'],
                ['cached-data' => 'value2']
            ],
            $actual
        );
    }

    /**
     * @covers ::get
     */
    public function test_get_NotArray()
    {
        $targetClass = new $this->testClassName('cache-key');
        Cache::shouldReceive('get')->with('cache-key')->once()->andReturn('not-array');

        //テスト対象メソッドの実行
        $actual = $targetClass->get();
        $this->assertSame([], $actual);
    }


    /**
     * @covers ::store
     */
    public function test_store()
    {
        $targetClass = new $this->testClassName('cache-key');
        $dataToStore = ['data-to-store' => 'value'];
        Cache::shouldReceive('put')->with('cache-key', $dataToStore)->once();
        $targetClass->store($dataToStore);
    }

    /**
     * @covers ::remove
     */
    public function test_remove()
    {
        $targetClass = new $this->testClassName('cache-key');
        Cache::shouldReceive('forget')->with('cache-key')->once();
        $targetClass->remove();
    }
}
