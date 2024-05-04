<?php

declare(strict_types=1);

namespace App\Models;

use Framework\Database;
use Framework\Exceptions\APIValidationException;

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
        $this->__tablename__ = 'friends';
    }

    public function sendRequest(int $receiverId, int $senderId): bool
    {
        $query = "SELECT id FROM users WHERE id = :id";
        $user = $this->db->query($query, ['id' => $receiverId])->find();

        $exist = "SELECT receiverId FROM {$this->__tablename__} WHERE receiverId = :receiverId AND senderId = :senderId";
        $existReuest = $this->db->query($exist, ['receiverId' => $receiverId, 'senderId' => $senderId])->find();

        if (!$user || $receiverId === $senderId || $existReuest) {
            throw new APIValidationException([
                'id' => ['User was not found or request already exists']
            ]);
        }

        $query = "INSERT INTO {$this->__tablename__} (receiverId, senderId, status, timestamp, uuid_socket_secret_key)
            VALUES (:receiverId, :senderId, 1, NOW(), :uuid_socket_secret_key)";

        $this->db->query($query, [
            'receiverId' => $receiverId,
            'senderId' => $senderId,
            'uuid_socket_secret_key' => gen_uuid(),
        ]);

        return true;
    }

    public function showRequest(int $receiverId)
    {
        $query = "SELECT f.*, u.first_name, u.last_name, u.profile_picture 
                FROM {$this->__tablename__} f 
                JOIN users u ON f.senderId = u.id 
                WHERE f.receiverId = :receiverId AND f.status = 1";
        return $this->db->query($query, ['receiverId' => $receiverId])->findAll();
    }

    public function acceptRequestStatus(int $receiverId, $senderId)
    {
        if ($receiverId === $senderId) {
            throw new APIValidationException([
                'id' => ['You can not accept your own request']
            ]);
        }

        $query = "UPDATE {$this->__tablename__} SET status = :status WHERE receiverId = :receiverId AND senderId = :senderId";
        $this->db->query($query, ['status' => 2, 'receiverId' => $receiverId, 'senderId' => $senderId]);
    }

    public function declineRequestStatus(int $receiverId, $senderId)
    {
        if ($receiverId === $senderId) {
            throw new APIValidationException([
                'id' => ['You can not decline your own request']
            ]);
        }
    
        $query = "DELETE FROM {$this->__tablename__} WHERE receiverId = :receiverId AND senderId = :senderId";
        $this->db->query($query, ['receiverId' => $receiverId, 'senderId' => $senderId]);
    }

    public function getStatus(int $receiverId, int $senderId)
    {
        if ($receiverId === $senderId) {
            throw new APIValidationException([
                'id' => ['You can not check your own request']
            ]);
        }
        $query = "SELECT status FROM {$this->__tablename__} WHERE receiverId = :receiverId AND senderId = :senderId";
        return $this->db->query($query, ['receiverId' => $receiverId, 'senderId' => $senderId])->find();
    }
}
