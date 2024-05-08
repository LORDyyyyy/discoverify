<?php

declare(strict_types=1);

namespace App\Models;

use Framework\Exceptions\ValidationException;
use Framework\Database;

use App\Interfaces\ModelInterface;
use App\Models\Storage\DBStorage;

use \DateTime;
use Framework\Exceptions\APIValidationException;
use Framework\HTTP;
use LDAP\Result;

class PostsModel extends DBStorage implements ModelInterface
{
    protected Database $db;
    public string $__tablename__;
    public int $id;
    public int $user_id;
    public int $page_id;
    public string $content;
    public DateTime $created_at;

    public function __construct(Database $db)
    {
        parent::__construct($db);
        $this->__tablename__ = 'posts';
    }

    public function addPost(array $postContent)
    {

        return parent::create($postContent);
    }
    public function deletePost(int $id, int $user_id)
    {
        $query = "SELECT * FROM posts WHERE id = :post_id AND user_id = :user_id";
        $result = $this->db->query($query, [
            'post_id' => $id,
            'user_id' => $user_id
        ])->count();

        if (!$result) {
            throw new APIValidationException([
                'message' => "unothorized user"
            ], HTTP::FORBIDDEN_STATUS_CODE);
        }

        $query = "DELETE FROM posts WHERE id =:id";
        $this->db->query($query, [
            'id' => $id
        ]);
    }

    public function addMedia(array $info, string $type)
    {
        $post_id = $info["post_id"];
        $media_url = $info["{$type}_url"];
        $query = "INSERT INTO post_{$type}s VALUES (:post_id, :url)";
        $this->db->query($query, [
            'post_id' => $post_id,
            "url" => $media_url,

        ]);
    }

    public function addComment(array $info)
    {
        $post_id = intval($info['post_id']);
        $query = "SELECT * FROM posts WHERE id = :post_id ";
        $result = $this->db->query($query, [
            'post_id' => $post_id
        ])->count();

        if (!$result) {
            throw new APIValidationException([
                'error' => ['post id was not found']
            ], HTTP::BAD_REQUEST_STATUS_CODE);
        }

        $query = "INSERT INTO post_comments (user_id, post_id, content)
         VALUES (:user_id,:post_id, :content)";
        $this->db->query($query, [
            'user_id' => $info['user_id'],
            'post_id' => $info['post_id'],
            'content' => $info['content']
        ]);
    }

    public function deleteComment(int $id, int $user_id)
    {
        $query = "SELECT * FROM post_comments WHERE id = :id AND user_id = :user_id";
        $result = $this->db->query($query, [
            'id' => $id,
            'user_id' => $user_id
        ])->count();

        if (!$result) {
            throw new APIValidationException([
                'message' => "unothorized user"
            ], HTTP::FORBIDDEN_STATUS_CODE);
        }
        $query = "DELETE FROM post_comments WHERE id =:id";
        $this->db->query($query, [
            'id' => $id
        ]);
    }

    public function sharePost(array $info)
    {
        $id = $info['post_id'];
        $query = "SELECT * FROM posts WHERE id = :id";
        $result = $this->db->query($query, [
            'id' => $id,
        ])->count();

        if (!$result) {
            throw new APIValidationException([
                'message' => "post doesn't exist"
            ], HTTP::FORBIDDEN_STATUS_CODE);
        }


        $post_id = intval($info['post_id']);
        $user_id = intval($info['user_id']);
        $content = $info['content'];
        $query = "INSERT INTO post_shares (post_id, user_id, content)
        VALUES (:post_id,:user_id, :content)";

        $this->db->query($query, [
            'post_id' => $post_id,
            'user_id' => $user_id,
            'content' => $content
        ]);
    }

    public function addReact($info)
    {
        $id = $info['post_id'];
        $query = "SELECT * FROM posts WHERE id = :id";
        $result = $this->db->query($query, [
            'id' => $id,
        ])->count();

        if (!$result) {
            throw new APIValidationException([
                'message' => "post doesn't exist"
            ], HTTP::FORBIDDEN_STATUS_CODE);
        }

        $user_id = intval($info['user_id']);
        $post_id = intval($info['post_id']);
        $type = intval($info['type']);
        $query = "INSERT INTO post_reacts (user_id, post_id, type)
        VALUES (:user_id,:post_id, :type)";

        $this->db->query($query, [
            'post_id' => $post_id,
            'user_id' => $user_id,
            'type' => $type
        ]);
    }
    public function countReacts(int $post_id): int
    {
        $query = "SELECT * FROM posts WHERE id = :id";
        $result = $this->db->query($query, [
            'id' => $post_id,
        ])->count();

        if (!$result) {
            throw new APIValidationException([
                'message' => "post doesn't exist"
            ], HTTP::FORBIDDEN_STATUS_CODE);
        }
        $query = "SELECT * FROM post_reacts  WHERE post_id =:post_id ";
        $result = $this->db->query($query, [
            'post_id' => $post_id
        ])->count();
        return $result;
    }



    public function dispalyPost(int $user_id)
    {

        $query = "SELECT p.*
        FROM posts p
        JOIN friends f ON (p.user_id = f.senderId OR p.user_id = f.receiverId)
        WHERE (f.senderId = :currentUserId OR f.receiverId = :currentUserId)
        AND f.status = 2
        AND p.is_private = 0;";
        $results = $this->db->query($query, [
            'currentUserId' => $user_id
        ])->findAll();

        foreach ($results as &$result) {
            $result['owner'] = $this->db->query("SELECT first_name, last_name, profile_picture FROM users WHERE id = :user_id", [
                'user_id' => $result["user_id"]
            ])->find();


            $result['comments'] = $this->db->query("SELECT * FROM post_comments WHERE post_id = :post_id", [
                'post_id' => $result["id"]
            ])->findAll();

            foreach ($result['comments'] as &$comment) {
                $comment['owner'] = $this->db->query("SELECT first_name, last_name, profile_picture FROM users WHERE id = :user_id", [
                    'user_id' => $comment["user_id"]
                ])->find();
            }

            $result['media'] = $this->db->query("SELECT post_id
            FROM (
                SELECT post_id
                FROM post_photos
                WHERE post_id = :post_id
                
                UNION ALL
                
                SELECT post_id
                FROM post_videos
                WHERE post_id = :post_id
            ) AS combined_results;", [
                'post_id' => $result["id"]
            ])->findAll();

            foreach ($result['media'] as &$media) {
                $media['content'] = $this->db->query("SELECT p.id AS post_id,
                'photo' AS media_type,
                pp.photo_url AS media_url
         FROM posts p
         JOIN post_photos pp ON p.id = pp.post_id
         WHERE p.id = :post_id
         
         UNION ALL
         
         SELECT p.id AS post_id,
                'video' AS media_type,
                pv.video_url AS media_url
         FROM posts p
         JOIN post_videos pv ON p.id = pv.post_id
         WHERE p.id = :post_id;", [
                    'post_id' => $media["post_id"]
                ])->findAll();
            }

            $result['reacts'] = $this->db->query("SELECT * FROM post_reacts WHERE post_id = :post_id", [
                'post_id' => $result["id"]
            ])->findAll();
        }
        // debug($results);
        return $results;
    }
}
