<?php

declare(strict_types=1);

namespace App\Models;

use Framework\Database;
use Framework\Exceptions\ValidationException;

use App\Interfaces\ModelInterface;
use App\Models\Storage\DBStorage;
use App\Config\Paths;

use \DateTime;

class UserModel extends DBStorage implements ModelInterface
{
    protected Database $db;
    public string $__tablename__;

    private int $id;
    private string $email;
    private int $email_verified;
    private string $first_name;
    private string $last_name;
    private string $password;
    private string $profile_picture = 'storage/defaults/pfp.jpg';
    private string $cover_picture = 'storage/defaults/cover.jpg';
    private DateTime $created_at;
    private DateTime $date_of_birth;
    private string $bio;
    private string $gender;
    private string $lives_in;
    private string $works_at;

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

    public function isEmailTaken(string $email)
    {
        $query = "SELECT * FROM {$this->__tablename__} WHERE email = :email";
        $user = $this->db->query($query, [
            'email' => $email
        ])->find();

        if ($user) {
            throw new ValidationException([
                'email' => ['Email is already taken']
            ]);
        }
    }

    public function create(array $data): string|false
    {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        $data['first_name'] = ucfirst($data['fname']);
        unset($data['fname']);

        $data['last_name'] = ucfirst($data['lname']);
        unset($data['lname']);

        $data['date_of_birth'] = $data['dateOfBirth'];
        unset($data['dateOfBirth']);

        $data['profile_picture'] = $this->profile_picture;
        $data['cover_picture'] = $this->cover_picture;

        return parent::create($data);
    }

    public function getCurrUser(string|int $id)
    {
        $query = "SELECT id,
        first_name as fname,
        last_name as lname,
        email,
        profile_picture as pfp,
        cover_picture as coverPicture,
        bio,
        DATE_FORMAT(date_of_birth, '%Y-%m-%d') as dateOfBirth,
        gender,
        lives_in as livesIn
        FROM {$this->__tablename__} WHERE id = :id";

        $result = $this->db->query($query, ['id' => intVal($id)])->find();

        return $result;
    }
}
