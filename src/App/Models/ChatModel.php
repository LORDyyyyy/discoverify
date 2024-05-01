<?php

declare(strict_types=1);

namespace App\Models;

use Framework\Exceptions\ValidationException;
use Framework\Database;

use App\Interfaces\ModelInterface;
use App\Models\Storage\DBStorage;

use \DateTime;
use Framework\Exceptions\APIValidationException;

class ChatModel extends DBStorage implements ModelInterface
{
    protected Database $db;
    public string $__tablename__;

    private int $id;
    private int $receiverId;
    private int $senderId;
    private string $content;
    private bool $seen;
    private DateTime $timestamp;

    public function __construct(Database $db)
    {
        parent::__construct($db);
        $this->__tablename__ = 'messages';
    }

    public function getUsersChat(string|int $senderID, string|int $recieverID,)
    {
    }

    public function getUserInfo(string|int $userID)
    {
        $query = "SELECT id,
        first_name as fname,
        last_name as lname,
        profile_picture as pfp
        FROM users WHERE id = :id";
        $user = $this->db->query($query, [
            'id' => intval($userID)
        ])->find();

        if (!$user) {
            throw new APIValidationException([
                'user' => ['User was not found']
            ]);
        }

        return $user;
    }
}
