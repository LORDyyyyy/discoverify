<?php

declare(strict_types=1);

namespace App\Models;

use Framework\Database;
use Framework\Exceptions\APIValidationException;

use App\Interfaces\ModelInterface;
use App\Models\Storage\DBStorage;

use \DateTime;

class ReportModel extends DBStorage implements ModelInterface
{
    protected Database $db;
    public string $__tablename__;
    private int $id;
    private int $reporterId;
    private int $reportedId;
    private string $type;
    private DateTime $timestamp;
    private string $message;
    private bool $resolved;

    private array $typeValues = ['users', 'pages', 'posts'];

    public function __construct(Database $db)
    {
        parent::__construct($db);
        $this->__tablename__ = 'reports';
    }

    public function sendReport(int $reporterId, int $reportedId, string $type, string $message)
    {
        if (!in_array($type, $this->typeValues)) {
            throw new APIValidationException([
                'type' => ['Invalid type']
            ]);
        }

        $query = "SELECT id FROM {$type} WHERE id = :id";
        $user = $this->db->query($query, ['id' => $reportedId])->find();

        if (!$user) {
            throw new APIValidationException([
                'id' => ["{$type} was not found"]
            ]);
        }

        $query = "INSERT INTO {$this->__tablename__} (reporterId, reportedId, type, message, timestamp)
            VALUES (:reporterId, :reportedId, :type, :message, NOW())";

        $this->db->query($query, [
            'reporterId' => $reporterId,
            'reportedId' => $reportedId,
            'type' => $type,
            'message' => $message,
        ]);

        // $this->skipOrRemving($type, $reportedId);
    }

    // public function skipOrRemving(string $type, int $reportedId)
    // {

    //     $countQuery = "SELECT COUNT(*) as count FROM {$this->__tablename__} WHERE type = :type AND reportedId = :reportedId";
    //     $countResult = $this->db->query($countQuery, [
    //         'type' => $type,
    //         'reportedId' => $reportedId,
    //     ])->find();

        
    //     if ($countResult['count'] && $type == "users")
    //     {
    //         $query = "SELECT COUNT(*)
    //                   FROM users u
    //                   INNER JOIN friends f ON u.id IN (f.receiverId, f.senderId)
    //                   WHERE u.id != :reportedId AND :reportedId IN (f.receiverId, f.senderId) AND status = 2";

    //         $count = $this->db->query($query, ['userId' => $reportedId])->findAll();
    //         if (($countResult / (int)$count) * 100 >= 60) {
    //             $query = "DELETE FROM type WHERE id = :reportedId";
    //             $this->db->query($query, ['id' => $reportedId]);
    //         }
    //     }
    // }
}