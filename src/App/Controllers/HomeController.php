<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Models\{
    UserModel,
    FriendsModel
};

class HomeController
{
    private TemplateEngine $view;
    private UserModel $userModel;
    private FriendsModel $friendModel;

    public function __construct(
        TemplateEngine $view,
        UserModel $userModel,
        FriendsModel $friendModel
    ) {
        $this->view = $view;
        $this->userModel = $userModel;
        $this->friendModel = $friendModel;
    }

    public function homeView()
    {
        // Middlewares: AuthRequiredMiddleware

        $user = $this->userModel->getCurrUser(intval($_SESSION['user']));
        $friendRequests = $this->friendModel->showRequest($user['id']);

        echo $this->view->render('index.php', [
            'title' => 'Home | Discoverify',
            'user' => $user,
            'friendRequests' => $friendRequests
        ]);
    }
}
