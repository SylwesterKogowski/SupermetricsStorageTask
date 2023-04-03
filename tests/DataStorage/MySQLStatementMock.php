<?php

namespace StorageTask\Tests\DataStorage;

class MySQLStatementMock
{
    public function execute() {
        return true;
    }
    public function close() {

    }

}