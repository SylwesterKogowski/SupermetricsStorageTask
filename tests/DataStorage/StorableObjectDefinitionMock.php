<?php

namespace StorageTask\Tests\DataStorage;

class StorableObjectDefinitionMock implements \StorageTask\DataStorage\StorableObjectDefinition
{

    /**
     * @inheritDoc
     */
    public function getModelName(): string
    {
        return 'test';
    }

    /**
     * @inheritDoc
     */
    public function getFactoryMethod(): callable
    {
        return function() {
            return new StorableObjectDataMock();
        };
    }

    /**
     * @inheritDoc
     */
    public function getPropertyNames(): array
    {
        return ['id','name'];
    }
}