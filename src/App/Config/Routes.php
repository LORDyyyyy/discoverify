<?php

declare(strict_types=1);

namespace App\Config;

use Framework\App;

use App\Controllers\{
    HomeController,
    ErrorController,
    ChatController,
    PostsController,
    AuthController,
    FriendsController,
};

use App\Middleware\{
    AuthRequiredMiddleware,
    GuestOnlyMiddleware,
};


function registerRoutes(App $app)
{
    $app->setErrorHandler([ErrorController::class, 'notFound']);

    $app->get('/', [HomeController::class, 'homeView'], false)
        ->add([AuthRequiredMiddleware::class]);

    $app->get('/login', [AuthController::class, 'loginView'], false)
        ->add([GuestOnlyMiddleware::class]);
    $app->post('/login', [AuthController::class, 'login'], false)
        ->add([GuestOnlyMiddleware::class]);
    $app->get('/signup', [AuthController::class, 'signupView'], false)
        ->add([GuestOnlyMiddleware::class]);
    $app->post('/signup', [AuthController::class, 'signup'], false)
        ->add([GuestOnlyMiddleware::class]);
    $app->get('/logout', [AuthController::class, 'logout'], false)
        ->add([AuthRequiredMiddleware::class]);
    $app->get('/forgotpass', [AuthController::class, 'forgotPassView'], false)
        ->add([GuestOnlyMiddleware::class]);
    $app->post('/forgotpass', [AuthController::class, 'forgotPass'], false)
        ->add([GuestOnlyMiddleware::class]);
    $app->get('/verifycode', [AuthController::class, 'verifycodeView'], false)
        ->add([GuestOnlyMiddleware::class]);
    $app->post('/verifycode', [AuthController::class, 'verifycode'], false)
        ->add([GuestOnlyMiddleware::class]);
    $app->get('/resetpass', [AuthController::class, 'resetPassView'], false)
        ->add([GuestOnlyMiddleware::class]);
    $app->post('/resetpass', [AuthController::class, 'resetPass'], false)
        ->add([GuestOnlyMiddleware::class]);


    $app->get('/friends', [FriendsController::class, 'friendsView'], false)
        ->add([AuthRequiredMiddleware::class]);
    $app->delete('/friends/{id}', [FriendsController::class, 'removeFriend'], false) // not implemented yet
        ->add([AuthRequiredMiddleware::class]);
    $app->get('/api/friends', [FriendsController::class, 'getFriends'], true) // good
        ->add([AuthRequiredMiddleware::class]);
    $app->post('/api/friends', [FriendsController::class, 'sendRequest'], true) // good
        ->add([AuthRequiredMiddleware::class]);
    $app->get('/api/requests/{id}', [FriendsController::class, 'checkStatus'], true) // good
        ->add([AuthRequiredMiddleware::class]);
    $app->get('/api/requests', [FriendsController::class, 'showRequests'], true) // good
        ->add([AuthRequiredMiddleware::class]);
    $app->put('/api/requests', [FriendsController::class, 'accecpRequest'], true) // good
        ->add([AuthRequiredMiddleware::class]);
    $app->delete('/api/requests', [FriendsController::class, 'declineRequest'], true) // good
        ->add([AuthRequiredMiddleware::class]);

    $app->post('/block', [FriendsController::class, 'blockFriend'], true)
        ->add([AuthRequiredMiddleware::class]);
    $app->get('/block', [FriendsController::class, 'showBlocked'], true)
        ->add([AuthRequiredMiddleware::class]);
    $app->delete('/block', [FriendsController::class, 'unblockFriend'], true)
        ->add([AuthRequiredMiddleware::class]);
    $app->post('/checkBlocck', [FriendsController::class, 'checkBlock'], true)
        ->add([AuthRequiredMiddleware::class]);

    $app->get('/chat', [ChatController::class, 'chatView'])
        ->add([AuthRequiredMiddleware::class]);
    $app->get('/chat/{room}', [ChatController::class, 'chatBoxView'])
        ->add([AuthRequiredMiddleware::class]);


    $app->post('/api/chat/join/{room}', [ChatController::class, 'joinChatRoom'], true)
        ->add([AuthRequiredMiddleware::class]);
    $app->post('/api/chat/{room}', [ChatController::class, 'emitToChat'], true)
        ->add([AuthRequiredMiddleware::class]);
    $app->get('/api/posts', [PostsController::class, 'test'], false);
    $app->post('/api/posts/', [PostsController::class, 'addPost'], false)
        ->add([AuthRequiredMiddleware::class]);
    $app->post('/api/posts/', [PostsController::class, 'addComment'], true)
        ->add([AuthRequiredMiddleware::class]);
}
