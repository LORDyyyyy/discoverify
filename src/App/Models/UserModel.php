<?php

declare(strict_types=1);


namespace App\Models;


use Framework\Database;
use App\Interfaces\ModelInterface;
use App\Models\Storage\DBStorage;

use Framework\Exceptions\ValidationException;

class UserModel extends DBStorage implements ModelInterface
{
    protected Database $db;
    public string $__tablename__;

    public function __construct(Database $db)
    {
        parent::__construct($db);
        $this->__tablename__ = 'users';
    }

    public function login(string $email, string $password): array
    {
        $query = "SELECT * FROM {$this->__tablename__} WHERE email = :email";
        $user = $this->db->query($query, [
            'email' => $email
        ])->find();

        $password_hash = password_verify($password, $user['password'] ?? '');

        if (!$user || !$password_hash) {
            throw new ValidationException([
                'password' => ['User was not found'],
                'credentials' => ['User was not found']
            ]);
        }

        return $user;
    }

    public function create(array $data)
    {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return parent::create($data);
    }
}
