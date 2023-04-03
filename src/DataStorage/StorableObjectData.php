<?php

namespace StorageTask\DataStorage;

/**
 * Interface for all storable objects
 */
interface StorableObjectData
{
    /**
     * Returns all properties in storable form
     * @return array an associative array of property_name => property_value
     */
    public function getAllProperties():array;

    /**
     * Sets all properties from storable form
     * @param array $properties an associative array of property_name => property_value
     */
    public function setAllProperties(array $properties):void;

    /**
     * Returns definition of this object
     * @return StorableObjectDefinition
     */
    public static function getDefinition(): StorableObjectDefinition;
}