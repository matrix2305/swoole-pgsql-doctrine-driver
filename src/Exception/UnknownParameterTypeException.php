<?php

namespace Doctrine\DBAL\Driver\Swoole\Coroutine\PgSQL\Exception;

class UnknownParameterTypeException extends \Exception
{
    public static function new($type): self
    {
        return new self(sprintf('Unknown parameter type, %d given.', $type));
    }

}