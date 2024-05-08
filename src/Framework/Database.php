<?php

declare(strict_types=1);

namespace Framework;

use PDO, PDOException, PDOStatement;

/**
 * Class Database.
 * 
 * A simple database class to interact with a database using PDO.
 */
class Database
{
    private PDO $connection;
    private PDOStatement $stmt;

    /**
     * Database constructor.
     *
     * @param string $driver The database driver.
     * @param array $config The database configuration.
     * @param string $username The database username.
     * @param string $password The database password.
     */
    public function __construct(string $driver, array $config, string $username, string $password)
    {
        $config = http_build_query(
            data: $config,
            arg_separator: ';'
        );

        $dsn = "{$driver}:{$config}";

        try {
            $this->connection = new PDO(
                $dsn,
                $username,
                $password,
                [
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            die("Unable to connect to database\n");
        }
    }

    /**
     * Executes a database query with optional parameters.
     *
     * @param string $query The SQL query to execute.
     * @param array $params An optional array of parameters to bind to the query.
     * @return Database Returns the current instance of the Database class.
     */
    public function query(string $query, array $params = []): Database
    {
        $this->stmt = $this->connection->prepare($query);

        $this->stmt->execute($params);

        return $this;
    }

    /**
     * Retrieves the number of rows returned by the previous SQL statement.
     * Used after calling the Database::query() method.
     *
     * @return int|false The number of rows returned by the previous SQL statement, or false on failure.
     */
    public function count(): int|false
    {
        return $this->stmt->fetchColumn();
    }

    /**
     * Retrieves a single row from the database.
     * Used after calling the Database::query() method.
     *
     * @return array|false The fetched row as an associative array, or false if no row is found.
     */
    public function find(): array | false
    {
        return $this->stmt->fetch();
    }

    /**
     * Retrieves all rows from the database.
     * Used after calling the Database::query() method.
     *
     * @return array An array containing all rows from the database.
     array index, column of result 
     */
    public function findAll(): array
    {
        return $this->stmt->fetchAll();
    }

    /**
     * Returns the last inserted ID from the database connection.
     *
     * @return string|false The last inserted ID, or false if no ID is available.
     */
    public function id(): string | false
    {
        return $this->connection->lastInsertId();
    }
}
