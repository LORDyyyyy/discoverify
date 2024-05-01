<?php

declare(strict_types=1);

namespace App\Config;

use Framework\App;

use App\Controllers\{
    HomeController,
    ErrorController,
    ChatController
};

use App\Middleware\{
    AuthRequiredMiddleware,
    GuestOnlyMiddleware,
};

use App\Controllers\{
    AuthController
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


    $app->get('/chat', [ChatController::class, 'chatView']) // temporary, will be removed
        ->add([AuthRequiredMiddleware::class]);

    $app->get('/chat/{room}', [ChatController::class, 'chatView'])
        ->add([AuthRequiredMiddleware::class]);
    $app->post('/api/chat/{room}', [ChatController::class, 'emit'], true)
        ->add([AuthRequiredMiddleware::class]);
}
