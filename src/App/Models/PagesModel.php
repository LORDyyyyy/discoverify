<?php

declare(strict_types=1);


namespace App\Models;

use App\Models\Storage\DBStorage;
use App\Interfaces\ModelInterface;
use App\Config\Paths;



use Framework\Exceptions\ValidationException;
use Framework\Database;



use \DateTime;




class PagesModel extends DBStorage implements ModelInterface
{
    protected Database $db;
    public string $__tablename__ = "pages";

    public int  $id;
    public int  $user_id;
    public string  $name;
    public string  $page_picture;
    public string  $cover_picture;
    public string  $description;
    public DateTime  $created_at;



    public function __construct(Database $db)
    {
        parent::__construct($db);
    }


    //  create page              


//     DROP TABLE IF EXISTS `pages`;
// CREATE TABLE `pages` (
//   `id` int unsigned NOT NULL AUTO_INCREMENT,
//   `user_id` int unsigned NOT NULL,
//   `name` varchar(50) NOT NULL,
//   `page_picture` varchar(256),
//   `cover_picture` varchar(256),
//   `description` varchar(256),
//   `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
//   PRIMARY KEY (`id`),
//   FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
// );
    public function createPage(array $data)
    {
        // $data['name'] = $data['pname'];
        // $data['page_picture'] = $data['page_pic'];
        // $data['cover_picture'] = $data['coverPic'];
        // $data['description'] = $data['dis'];
        return parent::create($data);
    }


    // delete page 


    public function deletePage(int $id, int $user_id)
    {
        $query = "SELECT * FROM pages WHERE id = :id AND user_id = :user_id";
        $result = $this->db->query($query, [
            'id' => $id,
            'user_id' => $user_id
        ])->count();

        if (!$result) {
            throw new ValidationException([
                'message' => "Page not found!"
            ]);
        }

        $query = "DELETE FROM pages WHERE id =:id";
        $this->db->query($query, [
            'id' => $id
        ]);
    }


    // follow  AND unfollow  feature 



    public function followPage(int $page_id, int $user_id)
    {
        $query = "SELECT * FROM pages WHERE  page_id = :page_id ";
        $result = $this->db->query($query, [
            'page_id' => $page_id,
        ])->count();

        if (!$result) {
            throw new ValidationException([
                'message' => "Page not found!" // 
            ]);
        }

        $query = "SELECT * FROM page_likes WHERE  page_id = :page_id AND user_id = :user_id ";
        $result = $this->db->query($query, [
            'page_id' => $page_id,
            'user_id' => $user_id
        ])->count();

        if ($result) {
            throw new ValidationException([
                'message' => "Already liked!" // 
            ]);
        }

        $query = "INSERT INTO page_likes (page_id , user_id) VALUES (:page_id , :user_id)";
        $this->db->query($query, [
            'page_id' => $page_id,
            'user_id' => $user_id
        ]);
    }





    public function UnfollowPage(int $page_id, int $user_id)
    {
        $query = "SELECT * FROM pages WHERE  page_id = :page_id ";
        $result = $this->db->query($query, [
            'page_id' => $page_id
        ])->count();

        if (!$result) {
            throw new ValidationException([
                'message' => "Page not found!" // 
            ]);
        }

        $query = "DELETE FROM page_likes WHERE page_id = :page_id AND user_id = :user_id";
        $this->db->query($query, [
            'page_id' => $page_id,
            'user_id' => $user_id
        ]);
    }


    // DROP TABLE IF EXISTS `pages`;
    // CREATE TABLE `pages` (
    //   `id` int unsigned NOT NULL AUTO_INCREMENT,
    //   `user_id` int unsigned NOT NULL,
    //   `name` varchar(50) NOT NULL,
    //   `page_picture` varchar(256),
    //   `cover_picture` varchar(256),
    //   `description` varchar(256),
    //   `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
    //   PRIMARY KEY (`id`),
    //   FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
    // );

public function displayContents($page_id)
{
    $query = "SELECT * FROM pages WHERE id = :page_id";
    $result = $this->db->query($query , [
        'page_id' => $page_id
    ])->find();

    if(!$result)
    {
        throw new ValidationException([
            'message' => "Page not found!" 
        ]);
    }
    return $result;
}


    // like and comment   mstf

    //  create post....    mstf






}
