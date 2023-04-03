<?php
require("../vendor/autoload.php");

$user = new \StorageTask\Models\User();
$user->setId("8a8e519b-8768-48d9-90c0-81569d3ded9b");
$user->setName("Matt Damon");


$db = new \StorageTask\DataStorage\MySQLDataStorage();
$db->addObject($user);

$_user = $db->findObject(\StorageTask\Models\UserDefinition::getInstance(), "id","8a8e519b-8768-48d9-90c0-81569d3ded9b");

if($_user->getAllProperties() == $user->getAllProperties()) {
    echo 'User successfully added and found!';
}