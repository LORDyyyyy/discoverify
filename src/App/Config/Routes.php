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
    UserController,
};

use App\Middleware\{
    AuthRequiredMiddleware,
    GuestOnlyMiddleware,
};

use App\Middleware\ControllersMiddlewares\{
    BlockedUserPageMiddleware
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
    /* Block Functions */
    $app->post('/block/{id}', [FriendsController::class, 'blockFriend'], false)
        ->add([AuthRequiredMiddleware::class]);
    $app->get('/block', [FriendsController::class, 'showBlocked'], false)
        ->add([AuthRequiredMiddleware::class]);
    $app->delete('/block/{id}', [FriendsController::class, 'unblockFriend'], false)
        ->add([AuthRequiredMiddleware::class]);
    $app->post('/checkBlock', [FriendsController::class, 'checkBlock'], true) // unused
        ->add([AuthRequiredMiddleware::class]);

    /* ChatController */
    $app->get('/chat', [ChatController::class, 'chatView'])
        ->add([AuthRequiredMiddleware::class]);
    $app->get('/chat/{room}', [ChatController::class, 'chatBoxView'])
        ->add([AuthRequiredMiddleware::class, BlockedUserPageMiddleware::class]);
    $app->post('/api/chat/join/{room}', [ChatController::class, 'joinChatRoom'], true)
        ->add([AuthRequiredMiddleware::class, BlockedUserPageMiddleware::class]);
    $app->post('/api/chat/{room}', [ChatController::class, 'emitToChat'], true)
        ->add([AuthRequiredMiddleware::class, BlockedUserPageMiddleware::class]);


    /* PostsController */
    $app->get('/posts', [PostsController::class, 'test'], false)
        ->add([AuthRequiredMiddleware::class]);

    $app->post('/posts', [PostsController::class, 'addPost'], false)
        ->add([AuthRequiredMiddleware::class]);


    $app->delete('/api/posts', [PostsController::class, 'deletePost'], true)
        ->add([AuthRequiredMiddleware::class]);

    $app->post('/api/posts/share', [PostsController::class, 'sharePost'], true)
        ->add([AuthRequiredMiddleware::class]);

    $app->post('/api/posts/{id}/reacts', [PostsController::class, 'addReact'], false)
        ->add([AuthRequiredMiddleware::class]);


    $app->get('/posts/{id}/comments', [PostsController::class, 'viewcomments'], false)
        ->add([AuthRequiredMiddleware::class]);

    $app->post('/posts/{id}/comments', [PostsController::class, 'addComment'], false)
        ->add([AuthRequiredMiddleware::class]);

    $app->delete('/posts/{id}/comments', [PostsController::class, 'deleteComment'], false)
        ->add([AuthRequiredMiddleware::class]);


    /* UserController */
    $app->get('/profile/{id}', [UserController::class, 'showProfile'], true)
        ->add([AuthRequiredMiddleware::class]);
    $app->post('/profile/{id}', [UserController::class, 'updateProfile'], true)
        ->add([AuthRequiredMiddleware::class]);

    $app->get('/notifications', [UserController::class, 'showNotifications'], true)
        ->add([AuthRequiredMiddleware::class]);
    $app->post('/sendNotifications', [UserController::class, 'sendNotifications'], true)
        ->add([AuthRequiredMiddleware::class]);
    $app->get('/seeNotifications', [UserController::class, 'markNotificationsAsRead'], true)
        ->add([AuthRequiredMiddleware::class]);
    $app->post('/search', [UserController::class, 'search'], true)
        ->add([AuthRequiredMiddleware::class]);
}
