<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Models\PagesModel;
use App\Services\ValidatorService;


class PagesController
{
    private TemplateEngine $view;
    private PagesModel $PagesModel;
    private ValidatorService $validator;

    public function __construct(
        TemplateEngine $view,
        PagesModel $PagesModel,
        ValidatorService $validator
    ) {
        $this->view = $view;
        $this->PagesModel = $PagesModel;
        $this->validator = $validator;
    }

    public function pagesview()
    {
        echo $this->view->render(
            "pages.php",
            [
                'title' => 'Pages | discoverify'
            ]
        );
    }

    public function createpage()
    {
        $this->validator->validatepage($_POST);
    }

    
    public function deletepage()
    {
        
        $this->validator->deletePageValidation($_POST);
        $this->PagesModel->deletePage((int)$_POST['id'], (int)$_SESSION['user']);
        redirectTo('/');
    }

}
