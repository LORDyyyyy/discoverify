<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\{
    FriendsModel,
    UserModel,
};
use Framework\TemplateEngine;
use App\Services\ValidatorService;
use Framework\HTTP;

class FriendsController
{
    private TemplateEngine $view;
    private FriendsModel $friendModel;
    private ValidatorService $validatorService;
    private UserModel $userModel;

    public function __construct(
        TemplateEngine $view,
        FriendsModel $friendModel,
        ValidatorService $validatorService,
        UserModel $userModel
    ) {
        $this->view = $view;
        $this->userModel = $userModel;
        $this->friendModel = $friendModel;
        $this->validatorService = $validatorService;
    }

    public function sendRequest()
    {
        // Middlewares: AuthRequiredMiddleware

        $this->validatorService->VaildateRequest($_POST);

        $senderId = $_SESSION['user'];

        $results = $this->friendModel->sendRequest((int)$_POST['id'], (int)$senderId);

        echo json_encode([
            'results' => $results,
        ]);
    }

    public function showRequests()
    {
        // Middlewares: AuthRequiredMiddleware

        $resivedId = $_SESSION['user'];
        $results = $this->friendModel->showRequest($resivedId);

        echo json_encode([
            'results' => $results
        ]);
    }

    public function checkStatus(array $params)
    {
        $this->validatorService->VaildateRequest($params);
        $resivedId = $_SESSION['user'];
        $results = $this->friendModel->getStatus((int)$resivedId, (int)$params['id']);

        echo json_encode([
            'results' => $results
        ]);
    }

    public function accecpRequest()
    {
        // Middlewares: AuthRequiredMiddleware

        $this->validatorService->VaildateRequest($_POST);
        $receiverId = $_SESSION['user'];
        $this->friendModel->acceptRequestStatus($receiverId, (int)$_POST['id']);

        echo json_encode([
            'status' => 'success',
            'code' => HTTP::OK_STATUS_CODE,
        ]);
    }

    public function declineRequest()
    {

        $this->validatorService->VaildateRequest($_POST);
        $receiverId = $_SESSION['user'];
        $this->friendModel->declineRequestStatus($receiverId, (int)$_POST['id']);


        echo json_encode([
            'status' => 'success',
            'code' => HTTP::OK_STATUS_CODE,
        ]);
    }

    public function getFriends()
    {
        $receiverId = $_SESSION['user'];
        $results = $this->friendModel->getFriends($receiverId);

        echo json_encode([
            'results' => $results
        ]);
    }

    public function friendsView()
    {
        // Middlewares: AuthRequiredMiddleware

        $userId = intval($_SESSION['user']);
        $currUser = $this->userModel->getCurrUser($userId);
        $friends = $this->friendModel->getFriends($userId);

        echo $this->view->render(
            'friends.php',
            [
                'title' => 'Friends | Discoverify',
                'user' => $currUser,
                'friends' => $friends,
            ]
        );
    }

    public function removeFriend()
    {
        // Middlewares: AuthRequiredMiddleware

        $this->validatorService->VaildateRequest($_POST);

        $userId = $_SESSION['user'];
        $this->friendModel->removeFriend($userId, (int)$_POST['id']);

        echo json_encode([
            'status' => 'success',
            'code' => HTTP::OK_STATUS_CODE,
        ]);
    }
}
