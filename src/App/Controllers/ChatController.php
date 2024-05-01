<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\ValidatorService;
use App\Models\{
    UserModel,
    ChatModel
};

use Framework\HTTP;

use \DateTime;

$port = $_ENV['SOCKET_PORT'];

class ChatController
{
    private TemplateEngine $templateEngine;
    private ValidatorService $validatorService;
    private UserModel $userModel;
    private ChatModel $chatModel;

    public function __construct(
        TemplateEngine $templateEngine,
        ValidatorService $validatorService,
        UserModel $userModel,
        ChatModel $chatModel
    ) {
        $this->templateEngine = $templateEngine;
        $this->validatorService = $validatorService;
        $this->userModel = $userModel;
        $this->chatModel = $chatModel;
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

    public function emit(array $pramas)
    {
        // Middlewares: AuthRequiredMiddleware

        $this->validatorService->chatMessage($_POST);

        date_default_timezone_set("Africa/Cairo");
        $timestamp = new DateTime();

        $client = createClient();

        $senderUser = $this->chatModel->getUserInfo($_SESSION['user']);

        $client->emit('chat', [
            'room' => $pramas['room'],
            'message' => $_POST['message'],
            'sender' => intval($_SESSION['user']),
            'timestamp' => $timestamp->format('h:i:s A'),
            'senderName' => $senderUser['fname'] . " " . $senderUser['lname'],
        ]);

        closeClient($client);

        echo json_encode([
            'status' => 'success',
            'code' => HTTP::OK_STATUS_CODE,
        ]);
    }
}
