<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\FriendsModel;
use Framework\TemplateEngine;
use App\Services\ValidatorService;
use Framework\HTTP;

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

    public function accecpRequest()
    {
        // Middlewares: AuthRequiredMiddleware

        $receiverId = $_SESSION['user'];
        $this->friendModel->acceptRequestStatus($receiverId);

        echo json_encode([
            'status' => 'success',
            'code' => HTTP::OK_STATUS_CODE,
        ]);
    }

    public function declineRequest()
    {
        $receiverId = $_SESSION['user'];
        $this->friendModel->declineRequestStatus($receiverId);

        echo json_encode([
            'status' => 'success',
            'code' => HTTP::OK_STATUS_CODE,
        ]);
    }
}
