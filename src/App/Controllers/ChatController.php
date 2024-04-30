<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\ValidatorService;
use App\Models\UserModel;

class ChatController
{
    private TemplateEngine $templateEngine;
    private ValidatorService $validatorService;
    private UserModel $userModel;

    public function __construct(
        TemplateEngine $templateEngine,
        ValidatorService $validatorService,
        UserModel $userModel
    ) {
        $this->templateEngine = $templateEngine;
        $this->validatorService = $validatorService;
        $this->userModel = $userModel;
    }

    public function chatView()
    {
        // Middlewares: AuthRequiredMiddleware

        $user = $this->userModel->getCurrUser($_SESSION['user']);

        echo $this->templateEngine->render(
            'chat.php',
            [
                'title' => 'Chat | Discoverify',
                'user' => $user
            ]
        );
    }
}
