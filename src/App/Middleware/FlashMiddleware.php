<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Interfaces\MiddlewareInterface;
use Framework\TemplateEngine;

/**
 * Class FlashMiddleware
 *
 * Middleware for handling flash messages and old form data.
 */
class FlashMiddleware implements MiddlewareInterface
{
    private TemplateEngine $view;

    /**
     * FlashMiddleware constructor.
     *
     * @param TemplateEngine $view The template engine instance.
     */
    public function __construct(TemplateEngine $view)
    {
        $this->view = $view;
    }

    /**
     * Process the middleware.
     *
     * @param callable $next The next middleware in the pipeline.
     */
    public function process(callable $next, ?array &$params)
    {
        $this->view->addGlobal('errors', $_SESSION['errors'] ?? []);
        unset($_SESSION['errors']);

        $this->view->addGlobal('oldFormData', $_SESSION['oldFormData'] ?? []);
        unset($_SESSION['oldFormData']);

        $next($params);
    }
}
