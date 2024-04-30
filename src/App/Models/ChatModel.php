<?php

declare(strict_types=1);

namespace App\Models;

use Framework\Exceptions\ValidationException;
use Framework\Database;

use App\Interfaces\ModelInterface;
use App\Models\Storage\DBStorage;

use \DateTime;

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
}
