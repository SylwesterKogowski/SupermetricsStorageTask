<?php

namespace StorageTask\DataStorage\Exceptions;

class DataStorageQueryException extends \Exception
{
    public function __construct(\mysqli $connection, string $message_prefix, ?\Throwable $previous = null)
    {
        $message = $message_prefix;
        if($connection->error) {
            $message .= ". MySQL error: $connection->error ($connection->errno)";
        }
        parent::__construct($message, 0, $previous);
    }

}