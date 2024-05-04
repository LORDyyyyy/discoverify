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
    FriendsController
};

use App\Middleware\{
    AuthRequiredMiddleware,
    GuestOnlyMiddleware,
};



function registerRoutes(App $app)
{
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

    $app->get('/friends', [FriendsController::class, 'sendRequestView'], true)
        ->add([AuthRequiredMiddleware::class]);
    $app->post('/friends', [FriendsController::class, 'sendRequest'], true)
        ->add([AuthRequiredMiddleware::class]);


    $app->get('/requests', [FriendsController::class, 'showRequestsView'], true)
        ->add([AuthRequiredMiddleware::class]);
    $app->post('/requests', [FriendsController::class, 'showRequests'], true)
        ->add([AuthRequiredMiddleware::class]);

    $app->get('/requests', [FriendsController::class, 'handleRequestAction'], true)
        ->add([AuthRequiredMiddleware::class]);
    $app->post('/requests', [FriendsController::class, 'handleRequestAction'], true)
        ->add([AuthRequiredMiddleware::class]);



    $app->get('/chat', [ChatController::class, 'chatView']) // temporary, will be removed
        ->add([AuthRequiredMiddleware::class]);

    $app->get('/chat/{room}', [ChatController::class, 'chatView'])
        ->add([AuthRequiredMiddleware::class]);

    $app->post('/api/chat/join/{room}', [ChatController::class, 'joinChatRoom'], true)
        ->add([AuthRequiredMiddleware::class]);
    $app->post('/api/chat/{room}', [ChatController::class, 'emitToChat'], true)
        ->add([AuthRequiredMiddleware::class]);

    $app->put('/api/test/{id}', [ChatController::class, 'testA'], true);


    $app->get('/api/posts',[PostsController::class,'test'],false);
   
    $app->post('/api/posts/',[PostsController::class,'addPost'],false)
    ->add([AuthRequiredMiddleware::class]);
   
    $app->post('/api/posts/',[PostsController::class,'addComment'],true)
    ->add([AuthRequiredMiddleware::class]);
    
    

   

   


        
}
