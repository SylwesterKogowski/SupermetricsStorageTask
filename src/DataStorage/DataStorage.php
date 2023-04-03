<?php

namespace StorageTask\DataStorage;

/**
 * Interface for storing and finding data objects
 */
interface DataStorage
{
    /**
     * Adds a data object to the storage
     * @param StorableObjectData $object
     * @return mixed
     */
    public function addObject(StorableObjectData $object);

    /**
     * Finds up to one object in the data storage and if found, returns it
     * @param callable $factory_method Factory method that returns ObjectData instance of desired type
     * @param string $search_property_name Property name by which the search is to be performed
     * @param mixed $search_property_value Property value for which to search for
     * @return StorableObjectData|null Iff object is found, an instance of that object type will be returned
     */
    public function findObject(
        StorableObjectDefinition $object_definition,
        string $search_property_name,
        $search_property_value
    ): ?StorableObjectData;
}