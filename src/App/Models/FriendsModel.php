<?php

declare(strict_types=1);

namespace App\Models;

use Framework\Database;
use Framework\Exceptions\APIValidationException;
use Framework\Exceptions\ValidationException;


use App\Interfaces\ModelInterface;
use App\Models\Storage\DBStorage;

use \DateTime;

class FriendsModel extends DBStorage implements ModelInterface
{
    protected Database $db;
    public string $__tablename__;

    private int $id;
    private int $receiverId;
    private int $senderId;
    private int $status;
    private DateTime $timestamp;
    private string $uuid_socket_secret_key;

    private array $statusValues = ['pending', 'accepted', 'declined'];

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
        $query = "SELECT f.receiverId as rId, f.senderId as sId, f.timestamp,
                u.first_name as fname,
                u.last_name as lname,
                u.profile_picture as pfp
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

        $query = "SELECT * FROM {$this->__tablename__}
        WHERE receiverId = :receiverId AND senderId = :senderId AND status = 1";
        $request = $this->db->query($query, ['receiverId' => $receiverId, 'senderId' => $senderId])->find();

        if (!$request) {
            throw new APIValidationException([
                'id' => ['Request was not found']
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
        $query = "SELECT receiverId, senderId, timestamp, status
        FROM {$this->__tablename__}
        WHERE (receiverId = :receiverId AND senderId = :senderId)
        OR (receiverId = :senderId AND senderId = :receiverId)";
        $result = $this->db->query($query, ['receiverId' => $receiverId, 'senderId' => $senderId])->find();

        if (!$result) {
            throw new APIValidationException([
                'id' => ['Request not found']
            ]);
        }

        $result['status'] = $this->statusValues[$result['status'] - 1];

        return $result;
    }

    public function getFriends(int $userId)
    {
        $query = "SELECT
            u.first_name as fname,
            u.last_name as lname,
            u.profile_picture as pfp,
            f.receiverId as rID,
            f.senderId as sID,
            f.uuid_socket_secret_key as uuid
            FROM users u
            INNER JOIN friends f ON u.id IN (f.receiverId, f.senderId)
            WHERE u.id != :userId AND :userId IN (f.receiverId, f.senderId) AND status = 2;";
        return $this->db->query($query, ['userId' => $userId])->findAll();
    }

    public function getSocketKey(int $receiverId, int $senderId): string
    {
        $query = "SELECT uuid_socket_secret_key FROM {$this->__tablename__}
        WHERE(receiverId = :receiverId AND senderId = :senderId)
        OR (receiverId = :senderId AND senderId = :receiverId)
        AND status = 2";
        $result = $this->db->query($query, [
            'receiverId' => $receiverId,
            'senderId' => $senderId
        ])->find();

        if (!$result) {
            return '';
        }

        return $result['uuid_socket_secret_key'];
    }

    public function removeFriend(int $receiverId, int $senderId)
    {
        if ($receiverId === $senderId) {
            throw new ValidationException([
                'id' => ['You can not remove yourself']
            ]);
        }
        $query = "DELETE FROM {$this->__tablename__}
        WHERE (receiverId = :receiverId AND senderId = :senderId)
        OR (receiverId = :senderId AND senderId = :receiverId)";
        $result = $this->db->query($query, ['receiverId' => $receiverId, 'senderId' => $senderId]);

        if (!$result) {
            throw new ValidationException([
                'id' => ['Friend not found']
            ]);
        }
    }
}
