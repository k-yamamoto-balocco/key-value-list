<?php

namespace GitBalocco\KeyValueList\Driver\DatabaseRepository;

use GitBalocco\KeyValueList\Contracts\DatabaseRepository;
use Illuminate\Support\Facades\DB;
use PDO;
use PDOStatement;

/**
 * Class LaravelDatabaseRepository
 * @package GitBalocco\KeyValueList\Driver\DatabaseRepository
 */
class RawSqlRepository implements DatabaseRepository
{
    /**
     * @var string $sql
     */
    private $sql;

    /**
     * RowSqlRepository constructor.
     * @param string $sql
     */
    public function __construct(string $sql)
    {
        $this->sql = $sql;
    }

    /**
     * @return array
     * @psalm-suppress UndefinedDocblockClass
     */
    public function select(): array
    {
        /** @var PDOStatement $sth */
        $sth = DB::getPdo()->prepare($this->sql);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
}
