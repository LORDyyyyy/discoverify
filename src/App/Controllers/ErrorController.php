<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use Framework\HTTP;

class ErrorController
{
    private TemplateEngine $view;

    public function __construct(TemplateEngine $view)
    {
        $this->view = $view;
    }

    public function notFound(array $params)
    {
        /*
        if (strpos($_SERVER['REQUEST_URI'], '/api/') === 0) {
            $this->apiError();
        } else {
            $this->routeError();
        }
        */

        if ($params['isAPI']) {
            $this->apiError();
        } else {
            $this->routeError();
        }
    }

    public function apiError()
    {
        http_response_code(HTTP::NOT_FOUND_STATUS_CODE);

        echo json_encode([
            'error' => HTTP::RESPONSE_CODES_TEXT[HTTP::NOT_FOUND_STATUS_CODE],
            'status' => HTTP::NOT_FOUND_STATUS_CODE,
            'message' => 'The requested resource was not found'
        ]);
    }

    public function routeError()
    {
        http_response_code(HTTP::NOT_FOUND_STATUS_CODE);

        echo $this->view->render(
            "errors/not-found.php",
            [
                'title' => HTTP::RESPONSE_CODES_TEXT[HTTP::NOT_FOUND_STATUS_CODE] . " | Discoverify",
                'message' => 'The requested resource was not found'
            ]
        );
    }
}
