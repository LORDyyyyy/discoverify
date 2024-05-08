<?php

declare(strict_types=1);

namespace App\Middleware\ControllersMiddlewares;

use Framework\Interfaces\{
    MiddlewareInterface,
};

use App\Models\FriendsModel;

/**
 * Class BlockedUserPageMiddleware
 * 
 * This middleware checks if a user is blocked and redirects them to a blocked page if necessary.
 */
class BlockedUserPageMiddleware implements MiddlewareInterface
{
    private FriendsModel $friendsModel;

    /**
     * BlockedUserPageMiddleware constructor.
     * 
     * @param FriendsModel $friendsModel The FriendsModel instance used to check if a user is blocked.
     */
    public function __construct(FriendsModel $friendsModel)
    {
        $this->friendsModel = $friendsModel;
    }

    /**
     * Process the middleware.
     * 
     * @param callable $next The next middleware or controller to be called.
     * @param array|null $params The parameters passed to the middleware.
     * @return mixed The result of the next middleware or controller.
     */
    public function process(callable $next, ?array &$params)
    {
        $isBlockedUser = isset($params['id']) ?
            (int)$params['id'] : (isset($params['room']) ?
                (int)$params['room']
                : null);

        if (!$isBlockedUser) {
            next($params);
        }

        $isBlocked = $this->friendsModel->checkBlock((int)$_SESSION['user'], $isBlockedUser);

        if ($isBlocked) {
            redirectTo('/block');
        }

        return $next($params);
    }
}
