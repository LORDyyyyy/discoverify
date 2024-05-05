<?php

declare(strict_types=1);

namespace App\Config;

use Framework\App;

use App\Controllers\{
    HomeController,
    ErrorController,
    PagesController,
    ChatController,
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

    
    $app->get('/pages/{id}' , [PagesController::class , 'pagesview'] , false  )
    ->add([AuthRequiredMiddleware::class]);
    $app->post( '/pages' , [PagesController::class , 'createpage'])
        ->add([AuthRequiredMiddleware::class]);

        
    $app->get('/friends', [FriendsController::class, 'sendRequestView'], true)
        ->add([AuthRequiredMiddleware::class]);
    $app->post('/friends', [FriendsController::class, 'sendRequest'], true)
        ->add([AuthRequiredMiddleware::class]);


    $app->get('/requests', [FriendsController::class, 'showRequests'], true)
        ->add([AuthRequiredMiddleware::class]);

    $app->put('/requests', [FriendsController::class, 'accecpRequest'], true)
        ->add([AuthRequiredMiddleware::class]);
    $app->delete('/requests', [FriendsController::class, 'declineRequest'], true)
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
}
