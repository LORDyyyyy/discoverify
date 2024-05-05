<?php

declare(strict_types=1);

namespace App\Models\Storage;

use Framework\Database;
use App\Interfaces\ModelInterface;

class DBStorage
{
    protected Database $db;
    public string $__tablename__;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    /**
     * Retrieve a record from the database based on the given ID.
     *
     * @param int|string $id The ID of the record to retrieve.
     * @param bool $all Whether to return all records or just one (default: false).
     * @return array|false The retrieved record.
     */
    protected function getWithID(string|int $id, bool $all = false): array|false
    {
        $query = "SELECT * FROM {$this->__tablename__} WHERE id = :id";

        return $all ?
            $this->db->query($query, ['id' => $id])->findAll() :
            $this->db->query($query, ['id' => $id])->find();
    }

    /**
     * Get one/all record with a specific columns for the query and execute it.
     *
     * @param array $data The data to be used in the query.
     * @param string $operator The operator to be used in the query (default: 'AND').
     * @param bool $all Whether to return all records or just one (default: false).
     * @return array|false The result of the query execution.
     */
    protected function getWithFields(array $data, string $operator = 'AND', bool $all = false): array|false
    {
        $fields = '';

        foreach ($data as $key => $value) {
            $fields .= "{$key} = :{$key}, {$operator}";
        }

        $fields = rtrim($fields, ", {$operator}");

        $query = "SELECT * FROM {$this->__tablename__} WHERE {$fields}";

        return $all ?
            $this->db->query($query, $data)->findAll() :
            $this->db->query($query, $data)->find();
    }

    /**
     * Retrieve all records from the database table.
     *
     * @return array An array containing all the records from the table.
     */
    protected function getAll(): array
    {
        $query = "SELECT * FROM {$this->__tablename__}";

        return $this->db->query($query)->findAll();
    }

    /**
     * Creates a new record in the database table.
     *
     * @param array $data The data to be inserted into the table.
     * @return string|false The ID of the newly created record, or false on failure.
     */
    protected function create(array $data): string|false
    {
        $fields = implode(', ', array_keys($data));
        $values = implode(', :', array_keys($data));

        $query = "INSERT INTO {$this->__tablename__} ({$fields}) VALUES (:{$values})";

        $this->db->query($query, $data);

        return $this->db->id();
    }

    /**
     * Updates a record in the database table.
     *
     * @param int|string $id The ID of the record to update.
     * @param array $data The data to be updated in the table.
     * @return void
     */
    protected function update(string|int $id, array $data): void
    {
        $fields = '';

        foreach ($data as $key => $value) {
            $fields .= "{$key} = :{$key}, ";
        }

        $fields = rtrim($fields, ', ');

        $query = "UPDATE {$this->__tablename__} SET {$fields} WHERE id = :id";

        $this->db->query($query, array_merge($data, ['id' => $id]));
    }

    /**
     * Deletes a record from the database table.
     *
     * @param int|string $id The ID of the record to delete.
     * @return void
     */
    protected function delete(string|int $id): void
    {
        $query = "DELETE FROM {$this->__tablename__} WHERE id = :id";

        $this->db->query($query, ['id' => $id]);
    }
}
