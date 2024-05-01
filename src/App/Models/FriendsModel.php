<?php

declare(strict_types=1);

namespace App\Models;

use Framework\Database;
use Framework\Exceptions\ValidationException;

use App\Interfaces\ModelInterface;
use App\Models\Storage\DBStorage;

use \DateTime;

class FriendModel extends DBStorage implements ModelInterface
{
    protected Database $db;
    public string $__tablename__;

    public function __construct(Database $db)
    {
        parent::__construct($db);
        $this->__tablename__ = 'friends';
    }


    public function sendRequest(int $id, int $senderId)
    {
        $query = "SELECT id FROM {$this->__tablename__} WHERE id = :id";
        $user = $this->db->query($query, ['id' => $id])->find();

        if (!$user) {
            throw new ValidationException([
                'id' => ['User was not found']
            ]);
        }

        $query = "INSERT INTO friends (receiverId, senderId, status, timestamp)
                  VALUES (:receiverId, :senderId, 1, NOW())";

        $this->db->query($query, [
            'receiverId' => $id,
            'senderId' => $senderId
        ]);
    }
}

