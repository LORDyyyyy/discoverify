<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Interfaces\MiddlewareInterface;
use Framework\TemplateEngine;

/**
 * Middleware class for adding template data.
 */
class TemplateDataMiddleware implements MiddlewareInterface
{
    private TemplateEngine $view;

    public function __construct(TemplateEngine $view)
    {
        $this->view = $view;
    }

    /**
     * Process the middleware.
     *
     * @param callable $next The next middleware.
     */
    public function process(callable $next, ?array &$params)
    {
        $this->view->addGlobal('title', $_ENV['APP_NAME'] ?? 'FB');

        $next($params);
    }
}
