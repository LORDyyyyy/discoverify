<?php

declare(strict_types=1);

namespace Framework;

class HTTP
{
    public const OK_STATUS_CODE = 200;
    public const CREATED_STATUS_CODE = 201;
    public const ACCEPTED_STATUS_CODE = 202;

    public const REDIRECT_STATUS_CODE = 302;

    public const BAD_REQUEST_STATUS_CODE = 400;
    public const UNAUTHORIZED_STATUS_CODE = 401;
    public const FORBIDDEN_STATUS_CODE = 403;
    public const NOT_FOUND_STATUS_CODE = 404;

    public const INTERNAL_SERVER_ERROR_STATUS_CODE = 500;
}
