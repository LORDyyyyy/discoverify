<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Models\{
    UserModel,
    FriendsModel,
    PostsModel
};

class HomeController
{
    private TemplateEngine $view;
    private UserModel $userModel;
    private FriendsModel $friendModel;
    private PostsModel $postModel;

    public function __construct(
        TemplateEngine $view,
        UserModel $userModel,
        FriendsModel $friendModel,
        PostsModel $postModel
    ) {
        $this->view = $view;
        $this->userModel = $userModel;
        $this->friendModel = $friendModel;
        $this->postModel = $postModel;
    }

    public function homeView()
    {
        // Middlewares: AuthRequiredMiddleware

        $user = $this->userModel->getCurrUser(intval($_SESSION['user']));
        $friendRequests = $this->friendModel->showRequest($user['id']);
        $postContents= $this->postModel->dispalyPost($_SESSION['user']);

        echo $this->view->render('index.php', [
            'title' => 'Home | Discoverify',
            'user' => $user,
            'friendRequests' => $friendRequests,
            'postContents'=>$postContents
        ]);
    }
}
