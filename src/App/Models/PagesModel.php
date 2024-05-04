<?php

declare(strict_types=1);


namespace App\Models;

use App\Models\Storage\DBStorage;
use App\Interfaces\ModelInterface;

use Framework\Database;

use \DateTime;




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