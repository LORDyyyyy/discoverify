<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\FriendModel;
use Framework\TemplateEngine;
use App\Services\ValidatorService;

class FriendsController
{
    private TemplateEngine $view;
    private FriendModel $friendModel;
    private ValidatorService $validatorService;

    public function __construct(TemplateEngine $view, FriendModel $friendModel, ValidatorService $validatorService)
    {
        $this->view = $view;
        $this->friendModel = $friendModel;
        $this->validatorService = $validatorService;
    }

    public function sendRequestView()
    {

        echo $this->view->render(
            'auth/friends.php',
            ['title' => 'Friends | Discoverify']
        );
    }

    public function sendRequest()
    {

        $this->validatorService->VaildateRequest($_POST);

        $senderId = $_SESSION['user'];

        $user = $this->friendModel->sendRequest($_POST['id'], $senderId);

        redirectTo('auth/friends');
    }
}