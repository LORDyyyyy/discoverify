<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use Framework\HTTP;

class ErrorController
{
    public function __construct(private TemplateEngine $view)
    {
    }

    public function notFound()
    {
        http_response_code(HTTP::NOT_FOUND_STATUS_CODE);

        echo $this->view->render("errors/not-found.php");
    }
}
