<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\FriendsModel;
use Framework\TemplateEngine;
use App\Services\ValidatorService;

class FriendsController
{
    private TemplateEngine $view;
    private FriendsModel $friendModel;
    private ValidatorService $validatorService;

    public function __construct(TemplateEngine $view, FriendsModel $friendModel, ValidatorService $validatorService)
    {
        $this->view = $view;
        $this->friendModel = $friendModel;
        $this->validatorService = $validatorService;
    }

    public function sendRequestView()
    {
        // Middlewares: AuthRequiredMiddleware

        echo $this->view->render(
            'auth/friends.php',
            ['title' => 'Friends | Discoverify']
        );
    }

    public function sendRequest()
    {
        // Middlewares: AuthRequiredMiddleware

        $this->validatorService->VaildateRequest($_POST);

        $senderId = $_SESSION['user'];

        $user = $this->friendModel->sendRequest((int)$_POST['id'], (int)$senderId);

        redirectTo('auth/friends');
    }
}