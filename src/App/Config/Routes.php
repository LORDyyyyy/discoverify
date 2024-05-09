<?php

declare(strict_types=1);

namespace App\Config;

use Framework\App;

use App\Controllers\{
    HomeController,
    ErrorController,
    PagesController,
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

    /* HomeController */
    $app->get('/', [HomeController::class, 'homeView'], false)
        ->add([AuthRequiredMiddleware::class]);

    /* AuthController */
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


    /* PagesController */
    $app->get('/pages/{id}', [PagesController::class, 'pagesview'], false)
        ->add([AuthRequiredMiddleware::class]);
    $app->post('/pagesForm', [PagesController::class, 'createpage'])
        ->add([AuthRequiredMiddleware::class]);
    $app->post('/pages/follow',  [PagesController::class, 'followpage'])
        ->add([AuthRequiredMiddleware::class]);
    $app->delete('/pages/follow',  [PagesController::class, 'unfollowpage'])
        ->add([AuthRequiredMiddleware::class]);
    $app->get('/pagesForm' , [PagesController::class, 'PageForm']);



    /* FriendsController */
    $app->get('/friends', [FriendsController::class, 'friendsView'], false)
        ->add([AuthRequiredMiddleware::class]);
    $app->delete('/friends/{id}', [FriendsController::class, 'removeFriend'], false)
        ->add([AuthRequiredMiddleware::class]);
    $app->get('/api/friends', [FriendsController::class, 'getFriends'], true)
        ->add([AuthRequiredMiddleware::class]);
    $app->post('/api/friends', [FriendsController::class, 'sendRequest'], true)
        ->add([AuthRequiredMiddleware::class]);
    $app->get('/api/requests/{id}', [FriendsController::class, 'checkStatus'], true)
        ->add([AuthRequiredMiddleware::class]);
    $app->get('/api/requests', [FriendsController::class, 'showRequests'], true)
        ->add([AuthRequiredMiddleware::class]);
    $app->put('/api/requests', [FriendsController::class, 'accecpRequest'], true)
        ->add([AuthRequiredMiddleware::class]);
    $app->delete('/api/requests', [FriendsController::class, 'declineRequest'], true)
        ->add([AuthRequiredMiddleware::class]);
    $app->post('/block', [FriendsController::class, 'blockFriend'], true)
        ->add([AuthRequiredMiddleware::class]);
    $app->get('/block', [FriendsController::class, 'showBlocked'], true)
        ->add([AuthRequiredMiddleware::class]);
    $app->delete('/block', [FriendsController::class, 'unblockFriend'], true)
        ->add([AuthRequiredMiddleware::class]);
    $app->post('/checkBlock', [FriendsController::class, 'checkBlock'], true)
        ->add([AuthRequiredMiddleware::class]);

    /* ChatController */
    $app->get('/chat', [ChatController::class, 'chatView'])
        ->add([AuthRequiredMiddleware::class]);
    $app->get('/chat/{room}', [ChatController::class, 'chatBoxView'])
        ->add([AuthRequiredMiddleware::class]);
    $app->post('/api/chat/join/{room}', [ChatController::class, 'joinChatRoom'], true)
        ->add([AuthRequiredMiddleware::class]);
    $app->post('/api/chat/{room}', [ChatController::class, 'emitToChat'], true)
        ->add([AuthRequiredMiddleware::class]);


    /* PostsController */
    $app->get('/api/posts', [PostsController::class, 'test'], false);
    $app->post('/api/posts/', [PostsController::class, 'addPost'], false)
        ->add([AuthRequiredMiddleware::class]);
    $app->post('/api/posts/', [PostsController::class, 'addComment'], true)
        ->add([AuthRequiredMiddleware::class]);
}
