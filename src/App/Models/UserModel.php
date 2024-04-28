<?php

declare(strict_types=1);


namespace App\Models;


use Framework\Database;
use App\Interfaces\ModelInterface;
use App\Models\Storage\DBStorage;

class UserModel extends DBStorage implements ModelInterface
{
    protected Database $db;
    public string $__tablename__;

    public function __construct(Database $db)
    {
        parent::__construct($db);
        $this->__tablename__ = 'users';
    }

    public function create(array $data)
    {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return parent::create($data);
    }
}
