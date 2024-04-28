<?php

declare(strict_types=1);

namespace Framework\Interfaces;

/**
 * Interface MiddlewareInterface
 * 
 * Represents a middleware interface that can process a request and call the next middleware in the chain with parameters.
 */
interface MiddlewareInterface
{
    /**
     * Process the middleware with the given parameters.
     *
     * @param callable $next The next middleware in the chain.
     * @param array $params The parameters for the middleware.
     * @return mixed The result of the middleware processing.
     */
    public function process(callable $next, ?array &$params);
}
