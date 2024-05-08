<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\{
    UserModel,
    NotificationsModel,
};
use Framework\TemplateEngine;
use App\Services\ValidatorService;
use Framework\HTTP;

class UserController
{
    private TemplateEngine $view;
    private ValidatorService $validatorService;
    private UserModel $userModel;
    private NotificationsModel $notificationsModel;

    public function __construct(
        TemplateEngine $view,
        ValidatorService $validatorService,
        UserModel $userModel,
        NotificationsModel $notificationsModel
    ) {
        $this->view = $view;
        $this->userModel = $userModel;
        $this->validatorService = $validatorService;
        $this->notificationsModel = $notificationsModel;
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

        $notifications = $this->notificationsModel->getNotifications($_SESSION['user']);

        echo json_encode([
            'notifications' => $notifications,
        ]);
    }

    public function sendNotifications()
    {
        // Middlewares: AuthRequiredMiddleware

        $this->validatorService->validateNotification($_POST);

        $this->notificationsModel->sendNotification($_POST['id'], $_POST['contant']);

        echo json_encode([
            'status' => 'success',
            'code' => HTTP::OK_STATUS_CODE,
        ]);
    }

    public function markNotificationsAsRead()
    {
        $this->notificationsModel->markAsRead($_SESSION['user']);
    
        echo json_encode([
            'status' => 'success',
            'code' => HTTP::OK_STATUS_CODE,
        ]);
    }

    public function search()
    {
        // Middlewares: AuthRequiredMiddleware
        $this->validatorService->validateSearch($_POST);

        $results = $this->userModel->search($_SESSION['user'], $_POST['query']);

        echo json_encode([
            'results' => $results,
        ]);
    }

}