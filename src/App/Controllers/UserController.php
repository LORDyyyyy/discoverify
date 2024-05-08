<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\{
    UserModel,
};
use Framework\TemplateEngine;
use App\Services\ValidatorService;
use Framework\HTTP;

class UserController
{
    private TemplateEngine $view;
    private ValidatorService $validatorService;
    private UserModel $userModel;

    public function __construct(
        TemplateEngine $view,
        ValidatorService $validatorService,
        UserModel $userModel
    ) {
        $this->view = $view;
        $this->userModel = $userModel;
        $this->validatorService = $validatorService;
    }

    public function showProfile()
    {
        // Middlewares: AuthRequiredMiddleware

        $user = $this->userModel->getUserById($_SESSION['user']);

        echo json_encode([
            'user' => $user,
        ]);
    }

    public function updateProfile()
    {
        // Middlewares: AuthRequiredMiddleware

        $this->validatorService->validateUpdate($_POST);

        $results = $this->userModel->updateUser($_SESSION['user'], $_POST['type'], $_POST['contant']);

        echo json_encode([
            'status' => 'success',
            'code' => HTTP::OK_STATUS_CODE,
        ]);
    }

    public function showNotifications()
    {
        // Middlewares: AuthRequiredMiddleware

        $notifications = $this->userModel->getNotifications($_SESSION['user']);

        echo json_encode([
            'notifications' => $notifications,
        ]);
    }

    
}