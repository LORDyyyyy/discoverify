<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;

class HomeController
{
    private TemplateEngine $view;

    public function __construct(TemplateEngine $view)
    {
        $this->view = $view;
    }

    public function homeView()
    {
        echo "Home";
    }
}
