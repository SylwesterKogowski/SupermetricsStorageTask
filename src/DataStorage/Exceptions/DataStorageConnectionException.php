<?php

namespace StorageTask\DataStorage\Exceptions;

/**
 * When an error happened on connection setup to some data storage
 */
class DataStorageConnectionException extends \Exception
{
    public function __construct(?\mysqli $connection, string $message_prefix = "", ?\Throwable $previous = null)
    {
        $message = $message_prefix;
        if(!empty($connection->connect_error)) {
            $message .= ". MySQL error: $connection->connect_error ($connection->connect_errno)";
        }
        parent::__construct($message, 0, $previous);
    }
}