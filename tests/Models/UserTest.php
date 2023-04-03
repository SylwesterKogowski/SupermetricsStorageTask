<?php

namespace StorageTask\Tests\Models;

use StorageTask\Models\User;
use PHPUnit\Framework\TestCase;
use StorageTask\Models\UserDefinition;

class UserTest extends TestCase
{

    public function testShouldGetName()
    {
        $test_user = new User();
        $test_properties = ['id' => '8a8e519b-8768-48d9-90c0-81569d3ded9b', 'name' => 'Matt Damon'];
        $test_user->setAllProperties($test_properties);
        $this->assertEquals($test_properties['name'], $test_user->getName());
    }

    public function testShouldSetId()
    {
        $test_user = new User();
        $test_properties = ['id' => '8a8e519b-8768-48d9-90c0-81569d3ded9b', 'name' => 'Matt Damon'];
        $test_user->setId($test_properties['id']);
        $user_properties = $test_user->getAllProperties();
        $this->assertEquals($user_properties['id'], $test_properties['id']);
    }

    public function testShouldGetDefinition()
    {
        $test_user = new User();
        $definition = $test_user->getDefinition();
        $this->assertInstanceOf(UserDefinition::class, $definition);
    }

    public function testShouldSetName()
    {
        $test_user = new User();
        $test_properties = ['id' => '8a8e519b-8768-48d9-90c0-81569d3ded9b', 'name' => 'Matt Damon'];
        $test_user->setName($test_properties['name']);
        $user_properties = $test_user->getAllProperties();
        $this->assertEquals($user_properties['name'], $test_properties['name']);
    }

    public function testShouldGetId()
    {
        $test_user = new User();
        $test_properties = ['id' => '8a8e519b-8768-48d9-90c0-81569d3ded9b', 'name' => 'Matt Damon'];
        $test_user->setAllProperties($test_properties);
        $this->assertEquals($test_properties['id'], $test_user->getId());
    }
}
