<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\ValidatorService;
use App\Models\{
    UserModel,
    PostsModel
};

use Framework\HTTP;
use App\Config\Paths;
use Framework\Exceptions\APIStatusCodeSend;
use \DateTime;
use ElephantIO\Engine\SocketIO\Session;
use Framework\Exceptions\ValidationException;

class PostsController
{
    private TemplateEngine $templateEngine;
    private ValidatorService $validatorService;
    private UserModel $userModel;
    private PostsModel $postModel;
    private DateTime $date;


    public function __construct(
        TemplateEngine $templateEngine,
        ValidatorService $validatorService,
        UserModel $userModel,
        PostsModel $postModel,

    ) {
        $this->templateEngine = $templateEngine;
        $this->validatorService = $validatorService;
        $this->userModel = $userModel;
        $this->postModel = $postModel;
        $this->date = new DateTime();
    }
    public function test()
    {
        
        echo $this->templateEngine->render('posts.php', [
            'title' => 'Home | Discoverify',
        ]);
        
    }

    public function addPost()
    {
        $this->validatorService->postsValidation($_POST);
        $postContent = [
            'user_id' => $_SESSION['user'],
            'page_id' => null,
            'content' => $_POST['content'],
        ];
        $newPostID = (int)$this->postModel->addPost($postContent);
        // photo validation 

        if (isset($_FILES['image'])) {

            // $this->validatorService->Mediavalidator($_FILES['image'],"photo");

            $this->addMedia($_FILES['image'], $newPostID, "photo");
        }

        if (isset($_FILES['video'])) {

            // $this->validatorService->Mediavalidator($_FILES['video'],"video");

            $this->addMedia($_FILES['video'], $newPostID, "video");
        }

        redirectTo("/");
    }

    public function deletePost()
    {
        $this->validatorService->validateIdOnly($_POST);
        $this->postModel->deletePost((int)$_POST['id'], (int)$_SESSION['user']);

        echo json_encode([
            "message" => "success"
        ]);
    }

    private function addMedia(array $files, int $newPostID, string $type)
    {
        $uploadPaths = $this->upload($files);
        foreach ($uploadPaths as $fileName => $uploadPath) {
            $info = [
                'post_id' => $newPostID,
                "{$type}_url" => $uploadPath
            ];
            $this->postModel->addMedia($info, $type);
        }
    }
    private function upload(array $file)
    {
        $uploadedFiles = [];

        // Loop through each uploaded file
        foreach ($file['tmp_name'] as $key => $tmp_name) {
            $fileExtention = pathinfo($file['name'][$key], PATHINFO_EXTENSION);

            $randomName = bin2hex(random_bytes(16)) . "." . $fileExtention;
            $uploadPath = Paths::STORAGE_UPLOADS . "/" . $randomName;
            $storagePath=  "/storage/uploads/" . $randomName;
            //$file['name'][$key]
            if (!move_uploaded_file($tmp_name, $uploadPath)) {
                throw new ValidationException(['receipt' => ['failed upload file']]);
            }

            // Store the file name and temporary file path in the array
            $uploadedFiles[$file['name'][$key]] = $storagePath;
        }

        return $uploadedFiles;
    }
    public function viewcomments()
    { {
            echo $this->templateEngine->render('comments.php', [
                'title' => 'Home | Discoverify',
            ]);
        }
    }


    public function addComment()
    {
        $this->validatorService->commentValidate($_POST);

        $info = [
            'user_id' =>  $_SESSION['user'],
            'post_id' => 8,
            'content' => $_POST['content']

        ];
        $this->postModel->addComment($info);

        echo json_encode([
            "message" => "success"
        ]);
    }

    public function deleteComment()
    {
        $this->validatorService->validateIdOnly($_POST);
        $this->postModel->deleteComment((int)$_POST['id'], (int)$_SESSION['user']);

        echo json_encode([
            "message" => "success"
        ]);
    }
    public function sharePost()
    {
        $info = [
            'post_id' => 8,
            'user_id' => $_SESSION['user'],
            'content' => $_POST['content']
        ];
        $this->postModel->sharePost($info);
        echo json_encode([
            "message" => "success"
        ]);
    }

    public function addReact()
    {
        $info = [
            'user_id' => $_SESSION['user'],
            'post_id' => 8,
            'type' => $_POST['type']
        ];
        $this->postModel->addReact($info);
        echo json_encode([
            "message" => "success"
        ]);
    }
    public function countReacts()
    {
        $this->postModel->countReacts($_POST['post_id']);
    }
}
