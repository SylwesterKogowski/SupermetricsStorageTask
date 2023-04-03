<?php

namespace StorageTask\DataStorage;


/**
 * Base class for all storable objects, automatically reads and writes properties to protected/public properties of the inheriting class
 */
abstract class StorableObjectDataBase implements StorableObjectData
{
    /**
     * @var array All properties are stored here by their name according to the definition of this object
     */
    protected array $all_properties = [];
    public function __construct() {
        $definition = $this->getDefinition();
        foreach($definition->getPropertyNames() as $property_name) {
            $this->all_properties[$property_name] = null;
        }
    }
    /**
     * @inheritDoc
     */
    public function getAllProperties(): array
    {
        $all_properties = [];
        foreach($this->getDefinition()->getPropertyNames() as $property_name) {
            $all_properties[$property_name] = $this->all_properties[$property_name];
        }
        return $all_properties;
    }

    /**
     * @inheritDoc
     */
    public function setAllProperties(array $properties): void
    {
        $property_names = $this->getDefinition()->getPropertyNames();
        foreach($properties as $property_name => $property_value) {
            if(in_array($property_name, $property_names)) {
                $this->all_properties[$property_name] = $property_value;
            } else {
                throw new \InvalidArgumentException("Tried to set unrecognized property $property_name");
            }
        }
    }

}