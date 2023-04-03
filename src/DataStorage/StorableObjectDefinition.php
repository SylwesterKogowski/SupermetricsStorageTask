<?php

namespace StorageTask\DataStorage;

/**
 * Interface for an object that defines properties of a StorableObject
 * Used by data storage for identifying how to store and retrieve the object
 */
interface StorableObjectDefinition
{

    /**
     * Returns model name of this object
     * @return string
     */
    public function getModelName(): string;

    /**
     * Returns a factory method returning new StorableObjectData
     * @return callable
     */
    public function getFactoryMethod(): callable;

    /**
     * Returns names of all properties
     * @return array
     */
    public function getPropertyNames(): array;

}