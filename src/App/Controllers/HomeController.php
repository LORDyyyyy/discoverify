<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Models\{
    UserModel,
    FriendsModel,
    PostsModel
};

use App\Services\ValidatorService;

class HomeController
{
    private TemplateEngine $view;
    private UserModel $userModel;
    private FriendsModel $friendModel;
    private PostsModel $postModel;
    private ValidatorService $validatorService;

    public function __construct(
        TemplateEngine $view,
        UserModel $userModel,
        FriendsModel $friendModel,
        PostsModel $postModel,
        ValidatorService $validatorService
    ) {
        $this->view = $view;
        $this->userModel = $userModel;
        $this->friendModel = $friendModel;
        $this->postModel = $postModel;
        $this->validatorService = $validatorService;
    }

    public function homeView()
    {
        // Middlewares: AuthRequiredMiddleware

        $user = $this->userModel->getCurrUser(intval($_SESSION['user']));
        $friendRequests = $this->friendModel->showRequest((int)$user['id']);
        $postContents = $this->postModel->dispalyPost((int)$_SESSION['user']);

        echo $this->view->render('index.php', [
            'title' => 'Home | Discoverify',
            'user' => $user,
            'friendRequests' => $friendRequests,
            'postContents' => $postContents
        ]);
    }

    public function searchView()
    {
        // Middlewares: AuthRequiredMiddleware

        // debug($_GET);

        $searchTerm = $_GET['s'] ?? '';

        $user = $this->userModel->getCurrUser(intval($_SESSION['user']));
        $friendRequests = $this->friendModel->showRequest($user['id']);
        $searchResults = $this->userModel->search(
            $user['id'],
            $searchTerm
        );

        echo $this->view->render('search.php', [
            'title' => 'Search | Discoverify',
            'user' => $user,
            'friendRequests' => $friendRequests,
            'searchResults' => $searchResults,
            'oldSearchForm' => $_GET['s'] ?? ''
        ]);
    }
}
