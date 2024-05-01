<?php

declare(strict_types=1);

namespace App\Models;

use Framework\Database;
use Framework\Exceptions\ValidationException;

use App\Interfaces\ModelInterface;
use App\Models\Storage\DBStorage;

use \DateTime;

class FriendsModel extends DBStorage implements ModelInterface
{
    protected Database $db;
    public string $__tablename__;

    public function __construct(Database $db)
    {
        parent::__construct($db);
        $this->__tablename__ = 'users';
    }

    public function sendRequest(int $receiverId, int $senderId)
    {
        $query = "SELECT id FROM {$this->__tablename__} WHERE id = :id";
        $user = $this->db->query($query, ['id' => $receiverId])->find();

        $exist = "SELECT receiverId FROM friends WHERE receiverId = :receiverId AND senderId = :senderId";
        $existReuest = $this->db->query($exist, ['receiverId' => $receiverId, 'senderId' => $senderId])->find();

        if (!$user || $receiverId === $senderId || $existReuest) {
            throw new ValidationException([
                'id' => ['User was not found or request already exists']
            ]);
        }

        $query = "INSERT INTO friends (receiverId, senderId, status, timestamp)
          VALUES (:receiverId, :senderId, 1, NOW())";

        $this->db->query($query, [
            'receiverId' => $receiverId,
            'senderId' => $senderId
        ]);
    }
}
