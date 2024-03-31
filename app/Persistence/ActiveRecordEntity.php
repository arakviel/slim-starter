<?php

namespace Insid\Blogonslim\Persistence;

use Insid\Blogonslim\Persistence\Util\ConnectionManager;
use Insid\Blogonslim\Persistence\Util\StringUtil;
use PDO;
use ReflectionObject;

abstract class ActiveRecordEntity
{
    /** @var string default identification for all tables */
    protected string $id;

    /**
     * @param string $name name of Entity property
     * @param mixed $value value of Entity property
     */
    public function __set(string $name, mixed $value)
    {
        $camelCaseName = StringUtil::underscoreToCamelCase($name);
        if (is_numeric($value) && $name !== 'id') {
            $this->$camelCaseName = intval($value);
        } elseif (is_bool($value)) {
            $this->$camelCaseName = boolval($value);
        } else {
            $this->$camelCaseName = $value;
        }
    }

    /**
     * select all data from current Entity
     *
     * @return array of entities
     */
    public function getAll(): array
    {
        $getAllSql = "SELECT * FROM " . static::getTableName();

        $pdo = $this->getPdo();
        $statement = $pdo->prepare($getAllSql);
        $statement->setFetchMode(PDO::FETCH_CLASS, static::class);

        if ($statement->execute()) {
            $result = [];
            while ($row = $statement->fetch()) {
                $result[] = $row;
            }
            return $result;
        }
        return [];
    }

    /**
     * @return string table name of current Entity
     */
    abstract protected static function getTableName(): string;

    /**
     * get PDO from ConnectionManager
     *
     * @return PDO configured PDO
     */
    private function getPdo(): PDO
    {
        $connectionManager = ConnectionManager::getInstance();
        return $connectionManager::get();
    }

    /**
     * select row data from current Entity
     *
     * @param string $id select by id
     * @return $this|null current Entity object
     */
    public function get(string $id = null): ?self
    {
        $getSql = "SELECT * FROM " . static::getTableName() . " WHERE id=:id";

        $pdo = $this->getPdo();
        $statement = $pdo->prepare($getSql);
        $statement->bindValue(":id", $id ?? $this->id);
        $statement->setFetchMode(PDO::FETCH_CLASS, static::class);

        if ($statement->execute()) {
            $result = $statement->fetch();
            return (!is_bool($result)) ? $result : null;
        }
        return null;
    }

    /**
     * select random row data from current Entity
     *
     * @param int $limit limit of rows
     * @return $this|null
     */
    public function getByRandom(int $limit): ?self
    {
        $getSql = "SELECT * FROM " . static::getTableName() . " ORDER BY RAND() LIMIT $limit";

        $pdo = $this->getPdo();
        $statement = $pdo->prepare($getSql);
        $statement->setFetchMode(PDO::FETCH_CLASS, static::class);

        if ($statement->execute()) {
            $result = $statement->fetch();
            return (!is_bool($result)) ? $result : null;
        }
        return null;
    }

    /**
     * insert or update Entity
     *
     * @return int|bool last inserted id | success update?
     */
    public function save(): int
    {
        $mappedProperties = $this->mapPropertiesToDbFormat();
        $dataFromDB = $this->get($this->getId());

        if ($dataFromDB == null) {
            return $this->insert($mappedProperties);
        } elseif (!$this->compEntities($dataFromDB)) {
            return $this->update($mappedProperties);
        }
        return 1;
    }

    /**
     * build array for named args by current Entity params and reflection
     *
     * @return array array of [property_name => propertyName]
     */
    private function mapPropertiesToDbFormat(): array
    {
        $reflector = new ReflectionObject($this);
        $properties = $reflector->getProperties();

        $mappedProperties = [];
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $propertyNameAsUnderscore = StringUtil::camelCaseToUnderscore($propertyName);
            $mappedProperties[$propertyNameAsUnderscore] = $this->$propertyName;
        }

        return $mappedProperties;
    }

    /**
     * @return string primary key
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * insert Entity
     *
     * @param array $mappedProperties properties from class by reflection
     * @return int last inserted id
     */
    private function insert(array $mappedProperties): int
    {
        $mappedPropertiesNotNull = array_filter($mappedProperties);
        $params = [];
        $columns = [];
        $params2values = [];
        $index = 1;

        foreach ($mappedPropertiesNotNull as $column => $value) {
            $params[] = ':param' . $index;
            $columns[] = $column;
            $params2values[':param' . $index] = $value;
            $index++;
        }

        $insertSql = 'INSERT INTO ' . static::getTableName() . '(' . implode(', ', $columns) . ') VALUES ('
            . implode(', ', $params) . ')';

        $pdo = $this->getPdo();
        $statement = $pdo->prepare($insertSql);
        $statement->setFetchMode(PDO::FETCH_CLASS, static::class);
        $statement->execute($params2values);
        return (int)$pdo->lastInsertId();
    }

    private function compEntities($entity): bool
    {
        $reflector = new ReflectionObject($this);
        $properties = $reflector->getProperties();
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            //echo "$propertyName | {$entity->$propertyName} != {$this->$propertyName} <br>";
            if ($entity->$propertyName != $this->$propertyName) {
                return false;
            }
        }
        return true;
    }

    /**
     * update Entity
     *
     * @param array $mappedProperties properties from class by reflection
     * @return int success update?
     */
    private function update(array $mappedProperties): int
    {
        $columns2params = [];
        $params2values = [];
        $index = 1;
        foreach ($mappedProperties as $column => $value) {
            $param = ":param" . $index; // :param1
            $columns2params[] = $column . " = " . $param; // column1 = :param1
            $params2values[$param] = $value; // [:param1 => value1]
            $index++;
        }

        $updateSql = "UPDATE " . static::getTableName() . " SET " . implode(", ", $columns2params) .
            " WHERE id = '" . $this->id . "'";

        $pdo = $this->getPdo();
        $statement = $pdo->prepare($updateSql);
        $statement->setFetchMode(PDO::FETCH_CLASS, static::class);
        $statement->execute($params2values);
        return $statement->rowCount();
    }

    public function delete(): ?self
    {
        $deleteSql = "DELETE FROM " . static::getTableName() . " WHERE id=:id";

        $pdo = $this->getPdo();
        $statement = $pdo->prepare($deleteSql);
        $statement->bindParam(":id", $this->id);

        return $statement->execute() ? $this : null;
    }

    public function getCount(): int
    {
        $getCountSql = "SELECT count(1) FROM " . static::getTableName();

        $pdo = $this->getPdo();
        $statement = $pdo->prepare($getCountSql);

        if ($statement->execute()) {
            return (int)$statement->fetchColumn(0);
        }
        return 0;
    }
}
