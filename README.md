# key-value-list
## このパッケージが提供する機能

- 一次元配列様のKey-Valueの対応をクラスとして定義する際の雛形となる抽象クラス KeyValueList
- Row-Coluｍn様の二次元配列データ構造を格納する際の雛形となる抽象クラス Classification
- 各実装クラスのデータをキャッシュする機能（対応フレームワーク：Laravel）

## 想定している用途

- DBに格納されているマスタテーブルの情報をキャッシュし、エイリアスとして利用（KeyValueList / Classification）
- DBにテーブルを作成するほどでもない規模の、アプリケーション内共通で利用される選択肢の定義（KeyValueList）
- 区分値IDに対応して分岐する処理内容をポリモフィズム的に実装する際にIDとfactoryの対応関係を記述しておく場所として（Classification）



# KeyValueList

一次元配列様のKey-Valueの対応をクラスとして定義する際に利用する抽象クラスです。例えば、以下のような血液型の一覧が、システムの複数箇所で利用されている状況があるとします。

```php
//以下のような、KeyとValueの組み合わせに意味があるデータ構造が
//アプリケーション内で共通して利用されている場合に、クラス化して定義するために利用する。
[
    1 => 'A',
    2 => 'B',
    3 => 'O',
    4 => 'AB',
];

```

このようなデータ構造はシステム内の1箇所にまとめて定義をしておくことが望ましいものですが、テーブルを設計してデータベースに格納しておくほどのものではありません。また、マスタテーブルを用意した方が良いようなデータの場合でも、アプリケーション開発初期段階においてはテーブル設計/シーディングの実装に先行してデータ構造の利用が必要になることも少なくないため、PHPのコードとしてデータ内容の定義を表現しておくことは有用です。このような場合に、KeyValueListは役立ちます。

KeyValueListを継承した具象クラスでは、Definerを返却するgetDefiner() メソッドを定義しなければなりません。Definerは、このリストの定義そのものです。以下に、実装の具体的なサンプルを示します。

## 実装サンプル1.配列により定義する

最も単純な利用方法は、ArrayDefinerを利用してKeyValueListを定義することです。KeyValueListを継承し、ArrayDefinerオブジェクトを返却するgetDefiner()メソッドを実装します。以下に実装サンプルを示します。

~~~php
<?php
namespace App\Samples;

use GitBalocco\KeyValueList\Contracts\Definer;
use GitBalocco\KeyValueList\Definer\ArrayDefiner;
use GitBalocco\KeyValueList\KeyValueList;

class ArrayKeyValueList extends KeyValueList
{
    public function getDefiner(): Definer
    {
        //ArrayDefinerにより、配列として定義する。
        //一次元配列として定義しなければならない点に注意。
        return new ArrayDefiner(
            [
                1 => 'A',
                2 => 'B',
                3 => 'O',
                4 => 'AB',
            ]
        );
    }
}
~~~



## 実装サンプル2.Eloquent Builder により内容を定義するKeyValueListの実装サンプル

Eloquent Builderを利用してリスト内容を定義したい場合、EloquentBuilderRepository と DatabaseKeyValueDefiner を利用します。以下では、prefectures テーブルに対するModelクラス、Prefecture を利用して実装を行う場合のサンプルを示します。

```php
<?php

namespace App\Samples;

use App\Model\Prefecture;
use GitBalocco\KeyValueList\Contracts\Definer;
use GitBalocco\KeyValueList\Definer\DatabaseKeyValueDefiner;
use GitBalocco\KeyValueList\Driver\DatabaseRepository\EloquentBuilderRepository;
use GitBalocco\KeyValueList\Driver\DatabaseRepository\LaravelModelRepository;
use GitBalocco\KeyValueList\KeyValueList;
use Illuminate\Support\Facades\App;

/**
 * Eloquent Builder を利用したKeyValueList定義のサンプル
 * 都道府県IDと都道府県名の対応関係を表す。
 * @package App\Samples
 */
class ModelKeyValueList extends KeyValueList
{
    /** @var Prefecture $model */
    private $model;

    public function __construct()
    {
        //依存するモデルをコンストラクタでpropertyに格納
        $this->model = App::make(Prefecture::class);
    }

    public function getDefiner(): Definer
    {
        //Repositoryオブジェクトを作成
        //モデルそのものではなく、newQuery()を介してクエリビルダを渡している点に注意。
        //必要に応じて、where() や orderBy() など条件を付加することも可能。
        $repo = new EloquentBuilderRepository($this->model->newQuery());

        //repositoryとkeyの列名、valueの列名を指定して作成したDatabaseKeyValueDefinerを返却
        return new DatabaseKeyValueDefiner($repo,'id', 'name');
    }
}
```



## 実装サンプル3.SQL文により内容を定義する
単純に、Select文によってリスト内容を定義することも可能です。この場合、RowSqlRepositoryと、DatabaseKeyValueDefinerを利用します。前項と同様に、prefectures テーブルが定義されているものとして実装サンプルを示します。

~~~php SqlKeyValueList.php
<?php
namespace App\Samples;

use GitBalocco\KeyValueList\Contracts\Definer;
use GitBalocco\KeyValueList\Definer\DatabaseKeyValueDefiner;
use GitBalocco\KeyValueList\Driver\DatabaseRepository\RowSqlRepository;
use GitBalocco\KeyValueList\KeyValueList;

/**
 * SQL文によるKeyValueListリスト定義のサンプル
 * 都道府県IDと都道府県名の対応関係を表す。
 * Class SampleKeyValueList
 * @package App\Samples
 */
class SqlKeyValueList extends KeyValueList
{
    public function getDefiner(): Definer
    {
        //SQL文を渡してrepositoryを作成
        $repository = new RowSqlRepository('SELECT id,name FROM prefectures ORDER BY rank ASC ');
        //repositoryとkey列名、value列名を渡して作成したDatabaseKeyValueDefinerを返却
        return new DatabaseKeyValueDefiner($repository,'id','name');
    }
}
~~~

## キャッシュ機能

KeyValueListを継承して作成したクラスは、リスト内容をキャッシュすることが可能です。

現時点では、対応しているフレームワークはLaravelのみです。

キャッシュを利用するKeyValueListを作成したい場合、LaravelCacheKeyValueListを継承してクラスを実装してください。

- キャッシュデータは、storage以下に作成されます。
- データベース内容をキャッシュする場合、データ更新時にキャッシュクリアを行うなど、アプリケーション側で適切にハンドリングを行ってください。
- LaravelCacheKeyValueListによって作成されるキャッシュ名は、static::class . '-cache' と定義されています。



## 備考

- KeyValueList は 
  IteratorAggregate, ArrayAccessインターフェースを実装しているため、配列様のようなアクセスや、foreach文でループ処理を行うことも可能です。
- KeyValueListの利用可能なメソッドについては、KeyValueListable インターフェースを参照してください。



# Classification

抽象クラスClassificationは、主に区分値として機能する類のマスタデータをアプリケーション上に表現することを意図したクラスです。Classificationクラスのメソッドを利用して、様々なアプリケーションの仕様を実装することができます。

Classificationクラスを継承した具象クラスでは、getDefiner() メソッドに加えて、getIdentityIndex() メソッドを実装しなければなりません。このメソッドは、データ構造中で識別子を保持している項目の名称を返却するよう実装してください。

## 実装サンプル1.Eloquent Builderにより内容を定義する

getDefiner() については基本的にKeyValueListと同様ですが、利用するDefinerクラスが異なります。データベースから取得する場合、DatabaseClassificationDefinerを利用してください。

```php ModelClassification.php
<?php

namespace App\Samples;

use App\Model\Prefecture;
use GitBalocco\KeyValueList\Classification;
use GitBalocco\KeyValueList\Contracts\Definer;
use GitBalocco\KeyValueList\Definer\DatabaseClassificationDefiner;
use GitBalocco\KeyValueList\Driver\DatabaseRepository\EloquentBuilderRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class ModelClassification extends Classification
{
    /** @var Model $model */
    private $model;

    public function __construct()
    {
        $this->model = App::make(Prefecture::class);
    }

    public function getDefiner(): Definer
    {
        $repo = new EloquentBuilderRepository($this->model->newQuery());
        return new DatabaseClassificationDefiner($repo);
    }

    protected function getIdentityIndex()
    {
        return 'id';
    }
}

```



## 実装サンプル2.SQL文により内容を定義する

SQLによる定義の場合も同様です。

~~~php
namespace App\Samples;

use GitBalocco\KeyValueList\Classification;
use GitBalocco\KeyValueList\Contracts\Definer;
use GitBalocco\KeyValueList\Definer\DatabaseClassificationDefiner;
use GitBalocco\KeyValueList\Driver\DatabaseRepository\RawSqlRepository;

class SqlClassification extends Classification
{
    protected function getIdentityIndex()
    {
        return 'id';
    }

    public function getDefiner(): Definer
    {
        $repo = new RawSqlRepository('select id,name,rank FROM prefectures ORDER BY rank ASC');
        return new DatabaseClassificationDefiner($repo);
    }
}

~~~

## 実装サンプル3.配列による定義、実践的なメソッドの例

配列を利用した定義の場合、KeyValueListと全く同様にArrayDefinerを利用します。ただし、データ内容が同じ列構造を持った複数の行で構成される二次元配列となるよう、実装者が注意して実装してください。

``` php SampleClassification.php
<?php

namespace App\Samples;

use GitBalocco\KeyValueList\Classification;
use GitBalocco\KeyValueList\Contracts\ArrayFilterInterface;
use GitBalocco\KeyValueList\Contracts\Definer;
use GitBalocco\KeyValueList\Contracts\KeyValueListable;
use GitBalocco\KeyValueList\Definer\ArrayDefiner;

/**
 * Class SampleClassification
 * Classificationの利用例
 */
class SampleClassification extends Classification
{
    /**
     * 識別子を示す情報が格納されているColumnの名称を定義する。
     * このサンプルでは、識別子が各Rowの 'id' に格納されている。
     * @return int|string
     */
    protected function getIdentityIndex()
    {
        return 'id';
    }
    
    /**
     * データの内容を定義し、Definerを返却する。
     * この例では、マスタデータ様のデータ構造を配列として表現したサンプルとなっている。
     *
     * Classificationクラスは、すべての行が同じ列構造を持つことを前提として設計されているので、
     * 行ごとに構造に差異がある複雑なデータ構造を返却した場合には想定通り動作しない可能性がある。注意すること。
     * @return Definer
     */
    public function getDefiner(): Definer
    {
        return new ArrayDefiner(
            [
                ['id' => 1, 'name' => 'Yoshiki', 'item' => 'passion', 'alive' => true, 'handleClass' => 'YoshikiLogic'],
                ['id' => 2, 'name' => 'Toshi', 'item' => 'voice', 'alive' => true, 'handleClass' => 'ToshiLogic'],
                ['id' => 3, 'name' => 'Pata', 'item' => 'guitar', 'alive' => true, 'handleClass' => 'PataLogic'],
                ['id' => 4, 'name' => 'Hide', 'item' => 'guitar', 'alive' => false, 'handleClass' => 'HideLogic'],
                ['id' => 5, 'name' => 'Taiji', 'item' => 'bass', 'alive' => false, 'handleClass' => 'TaijiLogic'],
            ]
        );
    }

    /**
     * Classification::listOf() の利用例1。
     * 'id'と 'item' の対応を持つInstantKeyValueListを返却している。
     * @return KeyValueListable
     */
    public function listOfItem(): KeyValueListable
    {
        return $this->listOf('item');
    }

    /**
     * Classification::listOf() の利用例2。
     * 'id'と 'name' の対応を持つInstantKeyValueListを返却している。
     * @return KeyValueListable
     */
    public function listOfName(): KeyValueListable
    {
        return $this->listOf('name');
    }

    /**
     * filteredListOf() の利用例。
     * ArrayFilterInterfaceを実装したクラスのインスタンスを引数として渡し、条件にマッチする行のみにフィルタリングした上で、
     * 'name' の値をInstantKeyValueListとして返却している。
     * @return KeyValueListable
     */
    public function listOfNameHasGuitar(): KeyValueListable
    {
        return $this->filteredListOf('name', $this->guitar());
    }

    /**
     * listOfNameHasGuitar() の実装例から呼び出されている、フィルタリング条件を生成するprivateメソッド。
     * ここでは簡便に利用例を示すために無名クラスを使用しているが、本来は別途クラス定義しておく方がよい。
     * @return ArrayFilterInterface
     */
    private function guitar(): ArrayFilterInterface
    {
        return new class() implements ArrayFilterInterface {
            public function arrayFilter(array $row): bool
            {
                return ($row['item'] === 'guitar');
            }
        };
    }

    /**
     * valueOf() の実践的な利用例。
     * IDを受け取り、IDに対応するロジックを実装したオブジェクトを返却する状況を想定した内容となっている。
     * インスタンス生成前にクラスの存在、特定のインターフェースを実装していることを検査する処理など。
     * @param int $id
     * @param mixed ...$args
     * @return mixed
     */
    public function createHandleClass(int $id, ...$args)
    {
        $className = $this->valueOf('handleClass', $id);

        if (!class_exists($className)) {
            throw new \LogicException($className . " doesnt exist.");
        }
        if (!is_subclass_of($className, SomeInterface::class)) {
            throw new \LogicException($className . " must implement " . SomeInterface::class . " .");
        }
        return new $className($args);
    }
}
```

## 備考

- Classificationを継承して作成したクラスは、getDefiner() 以外にpublicメソッドを持ちません。実装者が、アプリケーションの仕様として必要なpublicメソッドを適宜追加してください。

- キャッシュは、LaravelCacheClassification を利用してください。キャッシュされるのは、getDefiner() の定義内容です。

  

# 補足

- Laravel以外のキャッシュ機構に対応したい場合、CacheRepository インターフェースを実装したドライバクラスを用意し、LaravelCacheKeyValueListを参考に機能を追加してください。

  

  
