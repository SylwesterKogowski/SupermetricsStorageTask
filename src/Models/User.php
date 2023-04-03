<?php

namespace StorageTask\Models;

use StorageTask\DataStorage\StorableObjectDefinition;

/**
 * Represents an instance of a user
 */
class User extends \StorageTask\DataStorage\StorableObjectDataBase
{

    /**
     * @inheritDoc
     * @return StorableObjectDefinition
     */
    public static function getDefinition(): StorableObjectDefinition
    {
        return UserDefinition::getInstance();
    }

    /**
     * Returns Id of the user
     * @return ?string
     */
    public function getId(): ?string
    {
        return $this->all_properties['id'];
    }

    /**
     * Sets id of the user
     * @param ?string $id
     */
    public function setId(?string $id): void
    {
        $this->all_properties['id'] = $id;
    }

    /**
     * Returns name of the user
     * @return ?string
     */
    public function getName(): ?string
    {
        return $this->all_properties['name'];
    }

    /**
     * Sets name of the user
     * @param ?string $name
     */
    public function setName(?string $name): void
    {
        $this->all_properties['name'] = $name;
    }
}