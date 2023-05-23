<?php declare(strict_types=1);

namespace Doctrine\DBAL\Driver\Swoole\Coroutine\PgSQL;


use Doctrine\DBAL\Driver\ResultStatement;
use Swoole\Coroutine\PostgreSQL;

class SwooleStatement implements \IteratorAggregate, ResultStatement
{
    private $pg;
    private $sql;
    private $result;
    private $position = 0;

    public function __construct(PostgreSQL $pg, string $sql)
    {
        $this->pg = $pg;
        $this->sql = $sql;
    }

    public function bindValue($param, $value, $type = null)
    {
        // Implement parameter binding if needed
    }

    public function execute($params = null)
    {
        $result = $this->pg->query($this->sql);
        if ($result === false) {
            throw new \RuntimeException(sprintf("Query failed: %s\nError: %s", $this->sql, $this->pg->error));
        }
        $this->result = $result;
    }

    public function fetchAll($fetchMode = null, $fetchArgument = null, $ctorArgs = null)
    {
        $rows = [];
        while ($row = $this->fetch()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function fetch($fetchMode = null, $cursorOrientation = PDO::FETCH_ORI_NEXT, $cursorOffset = 0)
    {
        $result = $this->result;
        if ($result) {
            if ($this->position === 0) {
                $this->position++;
                return $result;
            }
            $this->result = false;
        }
        return false;
    }

    public function closeCursor()
    {
        // Implement the closeCursor method if needed
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->fetchAll());
    }

    public function setFetchMode($fetchMode, $arg2 = null, $arg3 = null)
    {
        // Implement the setFetchMode method if needed
    }

    public function columnCount()
    {
        // Implement the columnCount method
        return $this->result->numColumns;
    }

    public function fetchColumn($columnIndex = 0)
    {
        // Implement the fetchColumn method
        $row = $this->fetch();
        return $row[$columnIndex] ?? null;
    }

    // Implement other required ResultStatement methods as needed
}