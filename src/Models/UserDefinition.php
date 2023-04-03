<?php

namespace StorageTask\Models;

/**
 * @inheritDoc
 * Defines a model of a User instance
 */
class UserDefinition implements \StorageTask\DataStorage\StorableObjectDefinition
{
    /**
     * @var ?UserDefinition
     */
    private static $instance;

    /**
     * Returns instance of this definition
     * @return UserDefinition
     */
    public static function getInstance() {
        if(!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    /**
     * @inheritDoc
     */
    public function getModelName(): string
    {
        return 'user';
    }

    /**
     * Factory method
     * @return User
     */
    public static function createUser() {
        return new User();
    }
    /**
     * @inheritDoc
     */
    public function getFactoryMethod(): callable
    {
        return [self::class, 'createUser'];
    }

    /**
     * @inheritDoc
     */
    public function getPropertyNames(): array
    {
        return ['id','name'];
    }
}