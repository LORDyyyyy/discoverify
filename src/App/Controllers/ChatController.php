<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\ValidatorService;
use App\Models\UserModel;

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

$port = $_ENV['SOCKET_PORT'];

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

    public function fetchChat()
    {
        // Middlewares: AuthRequiredMiddleware

        echo json_encode([
            'status' => 'success',
        ]);
    }

    public function chat()
    {
        // Middlewares: AuthRequiredMiddleware

        echo json_encode([
            'status' => 'success',
            'post' => $_POST,
        ]);
    }

    public function emit()
    {
        $client = createClient();

        $client->emit('private_chat', [
            'message' => $_POST['message'],
            'sender' => $_POST['from'],
            'recipient' => $_POST['to'],
        ]);

        closeClient($client);

        echo json_encode([
            'status' => 'success',
            'post' => $_POST,
        ]);
    }

    public function testChat()
    {
        echo $this->templateEngine->render('test.php');
    }
}
