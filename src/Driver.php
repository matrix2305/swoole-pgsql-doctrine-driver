<?php declare(strict_types=1);

namespace Doctrine\DBAL\Driver\Swoole\Coroutine\PgSQL;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\AbstractPostgreSQLDriver;
use Doctrine\DBAL\Driver\ResultStatement;
use Swoole\Coroutine;
use Swoole\Coroutine\PostgreSQL;

final class Driver extends AbstractPostgreSQLDriver
{
    public function connect(array $params, ?string $username = null, ?string $password = null, array $driverOptions = []): Connection
    {
        $pg = new PostgreSQL();
        $pg->connect([
            'host' => $params['host'],
            'port' => $params['port'],
            'user' => $username,
            'password' => $password,
            'dbname' => $params['dbname'],
            // Add more connection options as needed
        ]);

        $connection = new SwooleConnection($pg);

        return $connection;
    }

    public function getName()
    {
        // TODO: Implement getName() method.
    }
}