<?php

namespace GitBalocco\KeyValueList\Tests;

use GitBalocco\KeyValueList\Classification;
use GitBalocco\KeyValueList\Contracts\ArrayFilterInterface;
use GitBalocco\KeyValueList\Contracts\Definer;
use GitBalocco\KeyValueList\Contracts\KeyValueListable;
use GitBalocco\KeyValueList\Definer\ArrayDefiner;
use GitBalocco\KeyValueList\InstantClassification;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \GitBalocco\KeyValueList\Classification
 * GitBalocco\KeyValueList\Tests\ClassificationTest
 */
class ClassificationTest extends TestCase
{
    /** @var $testClassName as test target class name */
    protected $testClassName = Classification::class;

    /**
     * @covers ::listOf
     */
    public function test_listOf()
    {
        $targetClass = $this->createClassification();
        //テスト対象メソッドの実行
        \Closure::bind(
            function () use ($targetClass) {
                /** @var KeyValueListable $actualListOfName テスト対象メソッドの実行 */
                $actualListOfName = $targetClass->listOf('name');
                //assertions
                $this->assertInstanceOf(KeyValueListable::class, $actualListOfName);
                $this->assertSame(
                    [
                        1 => 'Yoshiki',
                        2 => 'Toshi',
                        3 => 'Pata',
                        4 => 'Hide',
                        5 => 'Taiji',
                        6 => 'Heath',
                        7 => 'Sugizo',
                    ],
                    $actualListOfName->all()
                );

                /** @var KeyValueListable $actualListOfPart テスト対象メソッドの実行 */
                $actualListOfPart = $targetClass->listOf('part');
                $this->assertInstanceOf(KeyValueListable::class, $actualListOfPart);
                //assertions
                $this->assertSame(
                    [
                        1 => 'drum',
                        2 => 'vocal',
                        3 => 'guitar',
                        4 => 'guitar',
                        5 => 'base',
                        6 => 'base',
                        7 => 'guitar',
                    ],
                    $actualListOfPart->all()
                );

                /** @var KeyValueListable $actualListOfActive テスト対象メソッドの実行 */
                $actualListOfActive = $targetClass->listOf('active');
                $this->assertInstanceOf(KeyValueListable::class, $actualListOfActive);
                //assertions
                $this->assertSame(
                    [
                        1 => true,
                        2 => true,
                        3 => true,
                        4 => false,
                        5 => false,
                        6 => true,
                        7 => true,
                    ],
                    $actualListOfActive->all()
                );

                /** @var KeyValueListable $actualListOfActive テスト対象メソッドの実行 */
                $actualListOfHiragana = $targetClass->listOf(7);
                $this->assertInstanceOf(KeyValueListable::class, $actualListOfHiragana);
                //assertions
                $this->assertSame(
                    [
                        1 => 'よしき',
                        2 => 'とし',
                        3 => 'ぱた',
                        4 => 'ひで',
                        5 => 'たいじ',
                        6 => 'ひーす',
                        7 => 'すぎぞー',
                    ],
                    $actualListOfHiragana->all()
                );

                /** @var KeyValueListable $actualListOfActive テスト対象メソッドの実行 */
                $actualListOfInvalid = $targetClass->listOf('invalid-key-index');
                $this->assertInstanceOf(KeyValueListable::class, $actualListOfInvalid);
                $this->assertSame([], $actualListOfInvalid->all());
            },
            $this,
            $targetClass
        )->__invoke();
    }

    /**
     * @return mixed
     */
    public function createClassification()
    {
        /** @var mixed $targetClass */
        $targetClass = new class() extends Classification {
            protected function getIdentityIndex()
            {
                return 'id';
            }

            public function getDefiner(): Definer
            {
                return new ArrayDefiner(
                    [
                        ['id' => 1, 'name' => 'Yoshiki', 'part' => 'drum', 'active' => true, 7 => 'よしき'],
                        ['id' => 2, 'name' => 'Toshi', 'part' => 'vocal', 'active' => true, 7 => 'とし'],
                        ['id' => 3, 'name' => 'Pata', 'part' => 'guitar', 'active' => true, 7 => 'ぱた'],
                        ['id' => 4, 'name' => 'Hide', 'part' => 'guitar', 'active' => false, 7 => 'ひで'],
                        ['id' => 5, 'name' => 'Taiji', 'part' => 'base', 'active' => false, 7 => 'たいじ'],
                        ['id' => 6, 'name' => 'Heath', 'part' => 'base', 'active' => true, 7 => 'ひーす'],
                        ['id' => 7, 'name' => 'Sugizo', 'part' => 'guitar', 'active' => true, 7 => 'すぎぞー'],
                    ]
                );
            }

            public function activeNameList()
            {
                $notActiveFilter = new class() implements ArrayFilterInterface {
                    public function arrayFilter(array $row): bool
                    {
                        return ($row['active'] === true);
                    }
                };

                return $this->filteredListOf('name', $notActiveFilter)->all();
            }

        };
        return $targetClass;
    }

    /**
     * @covers ::filteredListOf
     */
    public function test_filteredListOf_Logic()
    {
        $argValueColIndex = '';
        $argFilter = \Mockery::mock(ArrayFilterInterface::class);

        $stubKeyValueList = \Mockery::mock(KeyValueListable::class);

        $stubClassification = \Mockery::mock(InstantClassification::class)
            ->shouldAllowMockingProtectedMethods();

        $stubClassification->shouldReceive('listOf')
            ->with($argValueColIndex)
            ->once()
            ->andReturn($stubKeyValueList);

        $targetClass = \Mockery::mock($this->testClassName)
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();
        $targetClass->shouldReceive('filteredClassification')
            ->with($argFilter)
            ->once()
            ->andReturn($stubClassification);


        $actual = $targetClass->filteredListOf($argValueColIndex, $argFilter);
        $this->assertSame($stubKeyValueList, $actual);
    }

    /**
     * @covers ::filteredListOf
     */
    public function test_filteredListOf()
    {
        $targetClass = $this->createClassification();
        $actual = $targetClass->activeNameList();
        $this->assertSame(
            [
                1 => "Yoshiki",
                2 => "Toshi",
                3 => "Pata",
                6 => "Heath",
                7 => "Sugizo",
            ],
            $actual
        );
    }


    /**
     * @covers ::filteredClassification
     */
    public function test_filteredClassification()
    {
        $targetClass = $this->createClassification();


        //テスト対象メソッドの実行
        \Closure::bind(
            function () use ($targetClass) {
                $notActiveFilter = new class() implements ArrayFilterInterface {
                    public function arrayFilter(array $row): bool
                    {
                        return ($row['active'] === false);
                    }
                };
                $actual = $targetClass->filteredClassification($notActiveFilter);
                //assertions
                $this->assertInstanceOf(InstantClassification::class, $actual);
                $this->assertSame(
                    [
                        3 => ['id' => 4, 'name' => 'Hide', 'part' => 'guitar', 'active' => false, 7 => 'ひで'],
                        4 => ['id' => 5, 'name' => 'Taiji', 'part' => 'base', 'active' => false, 7 => 'たいじ']
                    ],
                    $actual->getData()
                );
            },
            $this,
            $targetClass
        )->__invoke();
    }

    /**
     * @covers ::valueOf
     */
    public function test_valueOf()
    {
        $targetClass = $this->createClassification();

        \Closure::bind(
            function () use ($targetClass) {
                //assertions
                $this->assertSame('Yoshiki', $targetClass->valueOf('name', 1));
                $this->assertSame('Hide', $targetClass->valueOf('name', 4));
                $this->assertSame('base', $targetClass->valueOf('part', 5));
                $this->assertSame('ひーす', $targetClass->valueOf(7, 6));
                $this->assertSame(true, $targetClass->valueOf('active', 2));
            },
            $this,
            $targetClass
        )->__invoke();
    }

    /**
     * @covers ::findRow
     */
    public function test_findRow()
    {
        $targetClass = $this->createClassification();

        //テスト対象メソッドの実行
        \Closure::bind(
            function () use ($targetClass) {
                $actual = $targetClass->findRow(3);
                //assertions
                $this->assertSame(
                    ['id' => 3, 'name' => 'Pata', 'part' => 'guitar', 'active' => true, 7 => 'ぱた'],
                    $actual
                );
                //存在しないidを指定した場合、空の配列
                $actual = $targetClass->findRow(99);
                $this->assertSame([], $actual);
            },
            $this,
            $targetClass
        )->__invoke();
    }
}
