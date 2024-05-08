<?php

declare(strict_types=1);

namespace App\Models;

use Framework\Database;


use App\Interfaces\ModelInterface;
use App\Models\Storage\DBStorage;

use \DateTime;

class NotificationsModel extends DBStorage implements ModelInterface
{
    protected Database $db;
    public string $__tablename__;

    public function __construct(Database $db)
    {
        parent::__construct($db);
        $this->__tablename__ = 'notifications';
    }

    public function getNotifications(int $id)
    {
        $query = "SELECT * FROM {$this->__tablename__} WHERE user_id = :id";
        $result = $this->db->query($query, ['id' => $id])->find();

        return $result;
    }
    public function sendNotification(int $id, string $contant)
    {
        $query = "INSERT INTO notifications (user_id, content, timestamp)
                VALUES (:user_id, :content, NOW())";
        $this->db->query($query, ['user_id' => $id, 'content' => $contant]);
    }

    public function markAsRead(int $id)
    {
        $query = "UPDATE {$this->__tablename__} SET seen = :seen WHERE user_id = :user_id";
        $this->db->query($query, ['seen' => 1, 'user_id' => $id]);
    }
}
