<?php

namespace StorageTask\Tests\DataStorage;

use StorageTask\DataStorage\StorableObjectDefinition;

class StorableObjectDataMock implements \StorageTask\DataStorage\StorableObjectData
{

    private array $properties;

    /**
     * @inheritDoc
     */
    public function getAllProperties(): array
    {
        return $this->properties;
    }

    /**
     * @inheritDoc
     */
    public function setAllProperties(array $properties): void
    {
        $this->properties = $properties;
    }

    /**
     * @inheritDoc
     */
    public static function getDefinition(): StorableObjectDefinition
    {
        return new StorableObjectDefinitionMock();
    }
}