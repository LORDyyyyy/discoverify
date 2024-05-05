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
    public function toggleReacts()
    {
    }
    public function viewReacts()
    {
    }
    public function deleteComment()
    {
    }
    public function editComment()
    {
    }
}
