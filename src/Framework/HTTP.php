<?php

declare(strict_types=1);

namespace Framework;

class HTTP
{
    public const OK_STATUS_CODE = 200;
    public const OK_STATUS_CODE_TEXT = 'OK';

    public const CREATED_STATUS_CODE = 201;
    public const CREATED_STATUS_CODE_TEXT = 'Created';

    public const ACCEPTED_STATUS_CODE = 202;
    public const ACCEPTED_STATUS_CODE_TEXT = 'Accepted';

    public const NO_CONTENT_STATUS_CODE = 204;
    public const NO_CONTENT_STATUS_CODE_TEXT = 'No Content';

    public const REDIRECT_STATUS_CODE = 302;
    public const REDIRECT_STATUS_CODE_TEXT = 'Found';

    public const BAD_REQUEST_STATUS_CODE = 400;
    public const BAD_REQUEST_STATUS_CODE_TEXT = 'Bad Request';

    public const UNAUTHORIZED_STATUS_CODE = 401;
    public const UNAUTHORIZED_STATUS_CODE_TEXT = 'Unauthorized';

    public const FORBIDDEN_STATUS_CODE = 403;
    public const FORBIDDEN_STATUS_CODE_TEXT = 'Forbidden';

    public const NOT_FOUND_STATUS_CODE = 404;
    public const NOT_FOUND_STATUS_CODE_TEXT = 'Not Found';

    public const INTERNAL_SERVER_ERROR_STATUS_CODE = 500;
    public const INTERNAL_SERVER_ERROR_STATUS_CODE_TEXT = 'Internal Server Error';

    public const NOT_IMPLEMENTED_STATUS_CODE = 501;
    public const NOT_IMPLEMENTED_STATUS_CODE_TEXT = 'Not Implemented';

    public const SERVICE_UNAVAILABLE_STATUS_CODE = 503;
    public const SERVICE_UNAVAILABLE_STATUS_CODE_TEXT = 'Service Unavailable';

    public const RESPONSE_CODES_TEXT = [
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        204 => 'No Content',
        302 => 'Found',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        503 => 'Service Unavailable'
    ];
}
