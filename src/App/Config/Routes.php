<?php

declare(strict_types=1);

namespace App\Config;

use Framework\App;

use App\Controllers\{
    HomeController,
    ErrorController,
    FriendsController
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

    $app->get('/friends', [FriendsController::class, 'sendRequsetView'], false)
        ->add([AuthRequiredMiddleware::class]);

    $app->get('/friends', [FriendsController::class, 'sendRequset'], false)
        ->add([AuthRequiredMiddleware::class]);
}
