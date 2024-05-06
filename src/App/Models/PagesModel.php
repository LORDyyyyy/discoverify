<?php

declare(strict_types=1);


namespace App\Models;

use App\Models\Storage\DBStorage;
use App\Interfaces\ModelInterface;
use App\Config\Paths;



use Framework\Exceptions\ValidationException;
use Framework\Database;
use Framework\HTTP;
use Framework\Exceptions\APIValidationException;


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

    


    
    // create page for fetch the data!!!

    //  create page

    public function create(array $data)
    {
        $data['name'] = $this->name;
        $data['description'] = $this->description;
        $data['page_picture'] = $this->page_picture;
        $data['cover_picture'] = $this->cover_picture;
        $data['created_at'] = $this->created_at;
        
        return parent::create($data);
    }

    


    // delete page 


    public function deletePage(int $id, int $user_id )
    {
        $query = "SELECT * FROM pages WHERE id = :id AND user_id = :user_id";
        $result = $this->db->query($query, [
            'id' => $id,
            'user_id' => $user_id
        ])->count();

        if (!$result) {
            throw new ValidationException([
                'message' => "unothorized user"
            ]);
        }

        $query = "DELETE FROM pages WHERE id =:id";
        $this->db->query($query, [
            'id' => $id
        ]);
    }

    //  block/unblock 

    
    // follow  AND unfollow  feature 

    // like and comment   mstf

    //  create post....    mstf

    
    
    


}