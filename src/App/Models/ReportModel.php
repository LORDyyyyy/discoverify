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

    private array $typeValues = ['user', 'page', 'post'];

    public function __construct(Database $db)
    {
        parent::__construct($db);
        $this->__tablename__ = 'reports';
    }

    public function sendReport(int $reporterId, int $reportedId, string $typeOfReported, string $message)
    {
        if (!in_array($typeOfReported, $this->typeValues)) {
            throw new APIValidationException([
                'type' => ['Invalid type']
            ]);
        }

        if ($typeOfReported === 'user' && $reporterId === $reportedId) {
            throw new APIValidationException([
                'id' => ["The reporter cannot report themselves"]
            ]);
        }

        $query = "SELECT id FROM {$typeOfReported}s WHERE id = :id";
        $user = $this->db->query($query, ['id' => $reportedId])->find();

        if (!$user) {
            throw new APIValidationException([
                'id' => ["not found"]
            ]);
        }

        $query = "SELECT id FROM {$this->__tablename__} WHERE reporter_id = :reporterId AND reported_id = :reportedId";
        $report = $this->db->query($query, [
            'reporterId' => $reporterId,
            'reportedId' => $reportedId,
        ])->find();

        if ($report) {
            throw new APIValidationException([
                'id' => ["You have already reported this user"]
            ]);
        }

        $query = "INSERT INTO {$this->__tablename__} (reporter_id, reported_id, type, message, timestamp)
            VALUES (:reporterId, :reportedId, :type, :message, NOW())";

        $this->db->query($query, [
        'reporterId' => $reporterId,
        'reportedId' => $reportedId,
        'type' => $typeOfReported,
        'message' => $message,
    ]);

        $this->skipOrRemving($typeOfReported, $reportedId);
    }

    public function skipOrRemving(string $type, int $reportedId)
    {
        $countQuery = "SELECT COUNT(*) as count FROM {$this->__tablename__} WHERE type = :type AND reported_id = :reported_id";
        $countResult = $this->db->query($countQuery, [
            'type' => $type,
            'reported_id' => $reportedId,
        ])->find();

        if ($countResult['count'])
        {
            $query = "SELECT COUNT(*)
                    FROM users u
                      INNER JOIN friends f ON u.id IN (f.receiverId, f.senderId)
                      WHERE u.id != :reported_id AND :reported_id IN (f.receiverId, f.senderId) AND status = 2";

            $count = $this->db->query($query, ['reported_id' => $reportedId])->findAll();
            if (($countResult['count'] / (int)$count) * 100 >= 60) {
                $query = "DELETE FROM {$type}s WHERE id = :reported_id";
                $this->db->query($query, ['reported_id' => $reportedId]);
                $query = "DELETE FROM {$this->__tablename__} WHERE reported_id = :reported_id";
                $this->db->query($query, ['reported_id' => $reportedId]);
            }
        }
    }
}