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
        $this->friendModel->acceptRequestStatus((int)$receiverId, (int)$_POST['id']);

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
            'message' => 'Request declined successfully',
            'post' => $_POST
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
        $friendRequests = $this->friendModel->showRequest($userId);

        echo $this->view->render(
            'friends.php',
            [
                'title' => 'Friends | Discoverify',
                'user' => $currUser,
                'friends' => $friends,
                'friendRequests' => $friendRequests,
            ]
        );
    }

    public function removeFriend(array $params)
    {
        // Middlewares: AuthRequiredMiddleware

        $this->validatorService->VaildateRequest($params);

        $userId = $_SESSION['user'];
        $this->friendModel->removeFriend($userId, (int)$params['id']);

        redirectTo('/friends');
    }

    public function showBlocked()
    {
        $blockedBy = $userId = $_SESSION['user'];
        $results = $this->friendModel->showBlocked((int)$blockedBy);

        $currUser = $this->userModel->getCurrUser((int)$userId);
        $friendRequests = $this->friendModel->showRequest((int)$userId);

        echo $this->view->render(
            'blocked.php',
            [
                'title' => 'Blocked Users | Discoverify',
                'blocks' => $results,
                'user' => $currUser,
                'friendRequests' => $friendRequests,
            ]
        );
    }
    public function blockFriend(array $params)
    {
        $this->validatorService->VaildateRequest($params);
        $blockedBy = $_SESSION['user'];
        $this->friendModel->blockFriend((int)$blockedBy, (int)$params['id']);

        redirectTo('/friends');
    }


    public function unblockFriend(array $params)
    {
        $this->validatorService->VaildateRequest($params);
        $blockedBy = $_SESSION['user'];
        $this->friendModel->unblockFriend((int)$blockedBy, (int)$params['id']);

        redirectTo('/block');
    }

    public function checkBlock()
    {
        $this->validatorService->VaildateRequest($_POST);
        $blockedBy = $_SESSION['user'];
        $results = $this->friendModel->checkBlock((int)$blockedBy, (int)$_POST['id']);
        echo json_encode([
            'results' => $results,
        ]);
    }
}
