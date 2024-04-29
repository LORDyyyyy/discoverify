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
     * @return mixed The retrieved record.
     */
    protected function getID(string|int $id)
    {
        $query = "SELECT * FROM {$this->__tablename__} WHERE id = :id";

        return $this->db->query($query, ['id' => intval($id)])->find();
    }

    /**
     * Get the fields for the query and execute it.
     *
     * @param array $data The data to be used in the query.
     * @param string $operator The operator to be used in the query (default: 'AND').
     * @return mixed The result of the query execution.
     */
    protected function getWithFields(array $data, string $operator = 'AND')
    {
        $fields = '';

        foreach ($data as $key => $value) {
            $fields .= "{$key} = :{$key}, {$operator}";
        }

        $fields = rtrim($fields, ", {$operator}");

        $query = "SELECT * FROM {$this->__tablename__} WHERE {$fields}";

        return $this->db->query($query, $data)->find();
    }


    /**
     * Retrieve all records from the database table.
     *
     * @return array An array containing all the records from the table.
     */
    protected function getAll()
    {
        $query = "SELECT * FROM {$this->__tablename__}";

        return $this->db->query($query)->findAll();
    }

    /**
     * Creates a new record in the database table.
     *
     * @param array $data The data to be inserted into the table.
     * @return string The SQL query for inserting the data.
     */
    protected function create(array $data)
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
     * @return string The SQL query for updating the data.
     */
    protected function update(string|int $id, array $data)
    {
        $fields = '';

        foreach ($data as $key => $value) {
            $fields .= "{$key} = :{$key}, ";
        }

        $fields = rtrim($fields, ', ');

        $query = "UPDATE {$this->__tablename__} SET {$fields} WHERE id = :id";

        return $query;
    }

    /**
     * Deletes a record from the database table.
     *
     * @param int|string $id The ID of the record to delete.
     * @return string The SQL query for deleting the record.
     */
    protected function delete(string|int $id)
    {
        $query = "DELETE FROM {$this->__tablename__} WHERE id = :id";

        return $query;
    }
}
