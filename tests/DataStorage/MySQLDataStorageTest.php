<?php

namespace StorageTask\Tests\DataStorage;

use StorageTask\DataStorage\MySQLDataStorage;
use PHPUnit\Framework\TestCase;

class MySQLDataStorageTest extends TestCase
{
    /**
     * @var (\mysqli&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    private \mysqli|\PHPUnit\Framework\MockObject\MockObject $mysqli_mock;

    public function setUp(): void
    {
        $this->mysqli_mock = $this->getMockBuilder("mysqli")
            ->getMock();
    }

    public function testShouldAddObject()
    {
        //region we expect a mysql statement to be executed
        $mysql_statment_mock = $this->createStub("\mysqli_stmt");
        $mysql_statment_mock->method("execute")
            ->willReturn(true);
        $mysql_statment_mock->expects($this->once())
            ->method("execute")->withAnyParameters();
        $mysql_statment_mock->expects($this->once())
            ->method('close');
        //endregion

        $this->expectMySqlStatementToBePrepared($mysql_statment_mock, 'INSERT INTO ');

        $object_mock = new StorableObjectDataMock();
        $object_mock->setAllProperties(["id" => '8a8e519b-8768-48d9-90c0-81569d3ded9b', 'name' => 'Matt Damon']);

        $mysql_data_storage = new MySQLDataStorage($this->mysqli_mock);
        $mysql_data_storage->addObject($object_mock);

    }

    /**
     * @param \mysqli_stmt|\PHPUnit\Framework\MockObject\Stub|(\PHPUnit\Framework\MockObject\Stub&\mysqli_stmt) $mysql_statment_mock
     * @return void
     */
    public function expectMySqlStatementToBePrepared(
        \PHPUnit\Framework\MockObject\Stub|\mysqli_stmt $mysql_statment_mock,
        string $sql_statement_beginning
    ): void {
        $this->mysqli_mock
            ->method('prepare')
            ->willReturn($mysql_statment_mock);
        $this->mysqli_mock->expects($this->once())
            ->method("prepare")->with($this->stringStartsWith($sql_statement_beginning));
    }

}
