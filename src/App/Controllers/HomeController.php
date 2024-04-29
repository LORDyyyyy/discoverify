<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Models\UserModel;

class HomeController
{
    private TemplateEngine $view;
    private UserModel $userModel;

    public function __construct(TemplateEngine $view, UserModel $userModel)
    {
        $this->view = $view;
        $this->userModel = $userModel;
    }

    public function homeView()
    {
        echo "User logged in.";
    }
}
