<?php

declare(strict_types=1);

namespace App\Config;

use Framework\App;
use App\Middleware\{
    TemplateDataMiddleware,
    APIValidationExceptionMiddleware,
    ValidationExceptionMiddleware,
    SessionMiddleware,
    FlashMiddleware,
    CsrfTokenMiddleware,
    CsrfGuardMiddleware
};

/**
 * Registers the Global Middleware for the application, the order of middlewares matter
 * The Middleware added last gets executed first.
 *
 * @param App $app The application instance.
 * @return void
 */
function registerMiddleware(App $app)
{
    $app->addMiddleware(CsrfGuardMiddleware::class);
    $app->addMiddleware(CsrfTokenMiddleware::class);
    $app->addMiddleware(TemplateDataMiddleware::class);
    $app->addMiddleware(APIValidationExceptionMiddleware::class);
    $app->addMiddleware(ValidationExceptionMiddleware::class);
    $app->addMiddleware(FlashMiddleware::class);
    $app->addMiddleware(SessionMiddleware::class);
}
