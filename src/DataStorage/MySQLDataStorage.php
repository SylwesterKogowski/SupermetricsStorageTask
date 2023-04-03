<?php

namespace StorageTask\DataStorage;

use StorageTask\Configuration\Configuration;
use StorageTask\DataStorage\Exceptions\DataStorageConnectionException;
use StorageTask\DataStorage\Exceptions\DataStorageQueryException;

/**
 * MySQL implementation of data storage
 */
class MySQLDataStorage implements DataStorage
{
    private ?\mysqli $mysqli = null;

    /**
     * Constructs this object and immediately connects to the database
     * @param \mysqli|null $mysqli iff provided, will use the provided connection instead of creating a new one
     * @throws DataStorageConnectionException
     */
    public function __construct(?\mysqli $mysqli = null)
    {
        if($mysqli) {
            $this->mysqli = $mysqli;
        }
        $this->connect();
    }

    /**
     * @inheritDoc
     */
    public function addObject(StorableObjectData $object)
    {
        if(!$this->mysqli) {
            throw new DataStorageConnectionException($this->mysqli, 'Tried to add object without ready connection');
        }
        $all_properties = $object->getAllProperties();
        if(!$all_properties) {
            throw new \InvalidArgumentException("Object has no properties to store");
        }
        $property_names = array_keys($all_properties);

        $model_name = $object->getDefinition()->getModelName();
        $statement = $this->prepareInsertStatement($model_name, $property_names);

        try {
            if (!$statement->execute(array_values($all_properties))) {
                throw new DataStorageQueryException($this->mysqli, "Error while trying to add a $model_name object");
            }
        } finally {
            $statement->close();
        }
    }

    /**
     * @inheritDoc
     */
    public function findObject(
        StorableObjectDefinition $object_definition,
        string $search_property_name,
        $search_property_value
    ): ?StorableObjectData {
        if(!$this->mysqli) {
            throw new DataStorageConnectionException($this->mysqli, 'Tried to add object without ready connection');
        }
        $factory_method = $object_definition->getFactoryMethod();
        if(!$factory_method) {
            throw new \InvalidArgumentException('Must provide factory method');
        }
        $model_name = $object_definition->getModelName();
        if(!$model_name) {
            throw new \InvalidArgumentException('Model name cannot be empty');
        }
        if(!$search_property_name) {
            throw new \InvalidArgumentException('Searched property name cannot be empty');
        }
        $property_names = $object_definition->getPropertyNames();
        if(!$property_names) {
            throw new \InvalidArgumentException('Property names cannot be empty');
        }
        if(!in_array($search_property_name, $property_names)) {
            throw new \InvalidArgumentException('Searched property not defined in the object');
        }




        $search_query_statement = $this->prepareSearchQuery($model_name, $search_property_name);
        try {
            if(!$search_query_statement->execute([$search_property_value])) {
                throw new DataStorageQueryException($this->mysqli, "Error while searching in $model_name");
            }
            $result = $search_query_statement->get_result();
            if(!$result->num_rows) {
                return null;
            }
            /**
             * @var StorableObjectData $object
             */
            $object = $factory_method();
            $object->setAllProperties($result->fetch_assoc());
        } finally {
            $search_query_statement->close();
        }
        return $object;
    }

    private function connect()
    {
        try {
            if(!$this->mysqli) {
                $this->mysqli = new \mysqli(
                    Configuration::MYSQL_HOSTNAME, Configuration::MYSQL_USERNAME,
                    Configuration::MYSQL_PASSWORD, Configuration::MYSQL_DATABASE, Configuration::MYSQL_PORT
                );
            } else {
                $this->mysqli->ping();
            }
        } catch (\Exception $ex) {
            throw new DataStorageConnectionException($this->mysqli, 'Error while trying to connect to MySQL', $ex);
        }
    }

    private function disconnect()
    {
        if (!empty($this->mysqli)) {
            $this->mysqli->close();
            $this->mysqli = null;
        }
    }

    public function __destruct()
    {
        $this->disconnect();
    }

    /**
     * Prepares an insert statement prepared for executing with property values in same order as given propert names
     * @param string $table_name
     * @param array $column_names
     * @return \mysqli_stmt
     */
    public function prepareInsertStatement(string $table_name, array $column_names): \mysqli_stmt|false
    {
        if(!$table_name) {
            throw new \InvalidArgumentException("Table name cannot be empty");
        }
        if(!$column_names) {
            throw new \InvalidArgumentException("Insert at least one column name");
        }

        $insert_query = "INSERT INTO `$table_name` ";
        //column list
        $insert_query .= '(' . implode(',', array_map(fn($column_name) => "`$column_name`", $column_names)) . ')';
        //values list
        $insert_query .= ' VALUES(' . implode(',', array_fill(0, count($column_names), '?')) . ')';
        $statement = $this->mysqli->prepare($insert_query);
        if(!$statement) {
            throw new DataStorageQueryException($this->mysqli, "Error while preparing an insert statement for table $table_name");
        }
        return $statement;

    }

    /**
     * Prepares a search query statement ready to accept value to be searched in given column
     * @param string $table_name
     * @param string $searched_column_name
     * @return \mysqli_stmt
     * @throws DataStorageQueryException
     */
    private function prepareSearchQuery(string $table_name, string $searched_column_name)
    {
        if(!$table_name) {
            throw new \InvalidArgumentException("Table name cannot be empty");
        }
        if(!$searched_column_name) {
            throw new \InvalidArgumentException("Searched column name cannot be empty");
        }

        $select_query = "SELECT * FROM `$table_name` WHERE `$searched_column_name` = ? LIMIT 1";
        $statement = $this->mysqli->prepare($select_query);
        if(!$statement) {
            throw new DataStorageQueryException($this->mysqli, "Error while preparing a select statement for table $table_name");
        }
        return $statement;

    }
}