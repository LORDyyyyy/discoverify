<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\ValidatorService;
use App\Models\{
    UserModel,
    PostsModel,
    FriendsModel
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
    private FriendsModel $friendModel;

    public function __construct(
        TemplateEngine $templateEngine,
        ValidatorService $validatorService,
        UserModel $userModel,
        PostsModel $postModel,
        FriendsModel $friendModel

    ) {
        $this->templateEngine = $templateEngine;
        $this->validatorService = $validatorService;
        $this->userModel = $userModel;
        $this->postModel = $postModel;
        $this->friendModel = $friendModel;
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

        $newPostID = (int) $this->postModel->addPost($postContent);

        if (isset($_FILES['image'])) {
            echo "IMAGE UPLOADED";

            $this->addMedia($_FILES['image'], $newPostID, "photo");
        }

        if (isset($_FILES['video'])) {
            echo "VID UPLOADED";

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

        foreach ($file['tmp_name'] as $key => $tmp_name) {
            $fileExtention = pathinfo($file['name'][$key], PATHINFO_EXTENSION);

            $randomName = bin2hex(random_bytes(16)) . "." . $fileExtention;
            $uploadPath = Paths::STORAGE_UPLOADS . "/" . $randomName;
            $storagePath =  "/storage/uploads/" . $randomName;
            if (!move_uploaded_file($tmp_name, $uploadPath)) {
                throw new ValidationException(['receipt' => ['failed upload file']]);
            }

            $uploadedFiles[$file['name'][$key]] = $storagePath;
        }

        return $uploadedFiles;
    }
    public function viewcomments(array $params)
    {
        $user = $this->userModel->getCurrUser(intval($_SESSION['user']));
        $friendRequests = $this->friendModel->showRequest((int)$user['id']);
        $postContents = $this->postModel->dispalyPost((int)$_SESSION['user']);
        $isLiked = $this->postModel->isLiked($user['id'], (int) $params['id']);
        $likeCount = $this->postModel->countReacts((int)$params['id']);

        $post = [];
        foreach ($postContents as $content) {
            if ($content['id'] == $params['id']) {
                $post[] = $content;
                break;
            }
        }
        echo $this->templateEngine->render('comments.php', [
            'title' => 'Home | Discoverify',
            'user' => $user,
            'friendRequests' => $friendRequests,
            'postContents' => $post[0],
            'id' => $params['id'],
            'isLiked' => $isLiked ?? false,
            'likeCount' => $likeCount
        ]);
    }


    public function addComment(array $params)
    {
        $this->validatorService->commentValidate($_POST);

        $info = [
            'user_id' =>  $_SESSION['user'],
            'post_id' => $params['id'],
            'content' => $_POST['content']

        ];
        $this->postModel->addComment($info);

        redirectTo('.');
    }

    public function deleteComment(array $params)
    {
        $this->validatorService->validateIdOnly($params);
        $this->postModel->deleteComment((int)$params['id'], (int)$_SESSION['user']);

        redirectTo('.');
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

    public function addReact(array $params)
    {
        $info = [
            'user_id' => (int) $_SESSION['user'],
            'post_id' => (int) $params['id'],
            'type' => 1
        ];

        if ($_POST['action'] == 1) {
            $this->postModel->delReact((int)$_SESSION['user'], (int)$params['id']);
        } else
            $this->postModel->addReact($info);

        redirectTo('.');
    }

    public function countReacts()
    {
        $this->postModel->countReacts($_POST['post_id']);
    }
}
