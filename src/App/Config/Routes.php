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


function registerRoutes(App $app)
{
    $app->get('/', [HomeController::class, 'homeView'], false);
}
