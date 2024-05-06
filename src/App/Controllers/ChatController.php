<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\ValidatorService;
use App\Models\{
    UserModel,
    ChatModel,
    FriendsModel
};

use Framework\HTTP;
use Framework\Exceptions\APIStatusCodeSend;
use \DateTime;

$port = $_ENV['SOCKET_PORT'];

class ChatController
{
    private ValidatorService $validatorService;
    private TemplateEngine $templateEngine;
    private FriendsModel $friendsModel;
    private UserModel $userModel;
    private ChatModel $chatModel;

    public function __construct(
        ValidatorService $validatorService,
        TemplateEngine $templateEngine,
        FriendsModel $friendsModel,
        UserModel $userModel,
        ChatModel $chatModel
    ) {
        $this->validatorService = $validatorService;
        $this->templateEngine = $templateEngine;
        $this->friendsModel = $friendsModel;
        $this->userModel = $userModel;
        $this->chatModel = $chatModel;
    }

    public function chatView()
    {
        // Middlewares: AuthRequiredMiddleware

        $userID = intval($_SESSION['user']);

        $user = $this->userModel->getCurrUser($userID);

        $friends = $this->friendsModel->getFriends($userID);
        $friendRequests = $this->friendsModel->showRequest($userID);

        foreach ($friends as &$friend) {
            $friendId = $friend['sID'] == $userID ? $friend['rID'] : $friend['sID'];
            $friend['lastMessage'] = $this->chatModel->getLastMessage($userID, $friendId);
        }

        echo $this->templateEngine->render(
            'chat.php',
            [
                'title' => 'Chat | Discoverify',
                'user' => $user,
                'friends' => $friends ?? [],
                'room' => null,
                'friendRequests' => $friendRequests
            ]
        );
    }

    public function chatBoxView(array $params)
    {
        // Middlewares: AuthRequiredMiddleware

        $userID = intval($_SESSION['user']);

        $user = $this->userModel->getCurrUser($userID);

        $friends = $this->friendsModel->getFriends($userID);
        $friendRequests = $this->friendsModel->showRequest($userID);

        foreach ($friends as &$friend) {
            $friendId = $friend['sID'] == $userID ? $friend['rID'] : $friend['sID'];
            $friend['lastMessage'] = $this->chatModel->getLastMessage($userID, $friendId);
        }

        $socketKey = $this->friendsModel->getSocketKey(
            intval($userID),
            intval($params['room'])
        );

        if (!$socketKey) {
            redirectTo('/chat');
        }

        echo $this->templateEngine->render(
            'chat.php',
            [
                'title' => 'Chat | Discoverify',
                'user' => $user,
                'room' => $params['room'],
                'friends' => $friends ?? [],
                'friendRequests' => $friendRequests
            ]
        );
    }

    public function joinChatRoom(array $params)
    {
        // Middlewares: AuthRequiredMiddleware

        $socketKey = $this->friendsModel->getSocketKey(
            intval($_SESSION['user']),
            intval($params['room'])
        );

        if (!$socketKey) {
            throw new APIStatusCodeSend(
                [
                    'Room not found',
                    HTTP::NOT_FOUND_STATUS_CODE
                ]
            );
        }

        $messages = $this->chatModel->getUsersChat(
            intval($_SESSION['user']),
            intval($params['room'])
        );

        $this->chatModel->markMessagesAsSeen(
            intval($_SESSION['user']),
            intval($params['room'])
        );

        echo json_encode([
            'status' => 'success',
            'code' => HTTP::OK_STATUS_CODE,
            'socketKey' => $socketKey,
            'messages' => $messages
        ]);
    }


    public function emitToChat(array $params)
    {
        // Middlewares: AuthRequiredMiddleware

        $this->validatorService->chatMessage($_POST);

        date_default_timezone_set("Africa/Cairo");
        $timestamp = new DateTime();

        $socketKey = $this->friendsModel->getSocketKey(
            intval($_SESSION['user']),
            intval($params['room'])
        );

        $senderUser = $this->chatModel->getUserInfo($_SESSION['user']);

        $this->chatModel->insertMessage(
            intval($_SESSION['user']),
            intval($params['room']),
            $_POST['message'],
        );

        $client = createClient();

        $client->emit('chat', [
            'socketKey' => $socketKey,
            'content' => nl2br($_POST['message']),
            'senderId' => intval($_SESSION['user']),
            'receiverId' => intval($params['room']),
            'timestamp' => $timestamp->format('h:i:s A'),
            'senderName' => $senderUser['fname'] . " " . $senderUser['lname'],
            'senderPfp' => $senderUser['pfp']
        ]);

        closeClient($client);

        echo json_encode([
            'status' => 'success',
            'code' => HTTP::OK_STATUS_CODE,
        ]);
    }
}
