<?php

declare(strict_types=1);

namespace App\Models;

use Framework\Exceptions\ValidationException;
use Framework\Database;

use App\Interfaces\ModelInterface;
use App\Models\Storage\DBStorage;

use \DateTime;

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

    public function addMedia(array $info,string $type)
    {
        $post_id = $info["post_id"];
        $media_url = $info["{$type}_url"];
        $query = "INSERT INTO post_{$type}s VALUES (:post_id, :url)";
        $this->db->query($query, [
            'post_id' => $post_id,
            "url" => $media_url,
        
        ]);
    }

    public function toggleReacts()
    {
    }
    public function viewReacts()
    {
    }
    public function addComment()
    {
    }
    public function deleteComment()
    {
    }
    public function editComment()
    {
    }
}
