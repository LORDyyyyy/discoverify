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
    protected function get(string|int $id)
    {
        $query = "SELECT * FROM {$this->__tablename__} WHERE id = :id";

        return $this->db->query($query, ['id' => intval($id)])->find();
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

    protected function create(array $data)
    {
        $fields = implode(', ', array_keys($data));
        $values = implode(', :', array_keys($data));

        $query = "INSERT INTO {$this->__tablename__} ({$fields}) VALUES (:{$values})";

        return $query;
    }
}
