<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Interfaces\{
    MiddlewareInterface,
    NonAPIValidation
};
use Framework\TemplateEngine;

/**
 * Class CsrfTokenMiddleware
 *
 * This middleware generates and adds a CSRF token to the view's global variables.
 * The CSRF token is stored in the session and is used to protect against cross-site request forgery attacks.
 */
class CsrfTokenMiddleware implements MiddlewareInterface, NonAPIValidation
{
    private TemplateEngine $view;

    /**
     * CsrfTokenMiddleware constructor.
     *
     * @param TemplateEngine $view The template engine used to render views.
     */
    public function __construct(TemplateEngine $view)
    {
        $this->view = $view;
    }

    /**
     * Process the middleware.
     *
     * Generates a CSRF token if it doesn't exist in the session and adds it to the view's global variables.
     *
     * @param callable $next The next middleware in the pipeline.
     */
    public function process(callable $next, ?array &$params)
    {
        $_SESSION['token'] =  $_SESSION['token'] ?? bin2hex(random_bytes(32));

        $this->view->addGlobal('csrfToken', $_SESSION['token']);

        $next($params);
    }
}
