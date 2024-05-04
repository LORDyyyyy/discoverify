<?php

declare(strict_types=1);


namespace App\Models;

use App\Models\Storage\DBStorage;
use App\Interfaces\ModelInterface;

use Framework\Database;

use \DateTime;


// CREATE TABLE `pages` (
//     `id` int unsigned NOT NULL AUTO_INCREMENT,
//     `user_id` int unsigned NOT NULL,
//     `name` varchar(50) NOT NULL,
//     `page_picture` varchar(256),
//     `cover_picture` varchar(256),
//     `description` varchar(256),
//     `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
//     PRIMARY KEY (`id`),
//     FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
//   );

class PagesModel extends DBStorage implements ModelInterface
{
    protected Database $db;
    public string $__tablename__ = "pages" ;

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
}