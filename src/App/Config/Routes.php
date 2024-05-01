<?php

declare(strict_types=1);

namespace App\Config;

use Framework\App;

use App\Controllers\{
    HomeController,
    ErrorController,
};

use App\Middleware\{
    AuthRequiredMiddleware,
    GuestOnlyMiddleware,
};

use App\Controllers\{
    AuthController,
    FriendsController,
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

    $app->get('/friends', [FriendsController::class, 'sendRequestView'], false)
        ->add([AuthRequiredMiddleware::class]);
    $app->post('/friends', [FriendsController::class, 'sendRequest'], false)
        ->add([AuthRequiredMiddleware::class]);
}
