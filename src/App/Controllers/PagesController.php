<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Models\PagesModel;
use App\Services\ValidatorService;
use App\Config\Paths;
use Framework\Exceptions\ValidationException;


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
        $pageContents = $this->PagesModel->displayContents($_GET['page_id']); //
        echo $this->view->render(
            "pages.php",
            [
                'title' => 'Pages | discoverify'
            ]
        );
    }

    // POST /createpage
    public function createpage()
    {
        $this->validator->validatepage($_POST);
        $pagepic = $this->upload($_POST['page_pic']);
        $coverpic = $this->upload($_POST['coverPic']);
        $this->PagesModel->createPage($_SESSION['user'], $_POST['pname'],$pagepic,
        $coverpic,  $_POST['dis']);
        
    }

    private function upload(array $file)
    {
        $uploadedFiles = [];

        foreach ($file['tmp_name'] as $key => $tmp_name) {
            $fileExtention = pathinfo($file['name'][$key], PATHINFO_EXTENSION);

            $randomName = bin2hex(random_bytes(16)) . "." . $fileExtention;
            $uploadPath = Paths::STORAGE_UPLOADS . "/" . $randomName;
            $storagePath=  "/storage/uploads/" . $randomName;
            if (!move_uploaded_file($tmp_name, $uploadPath)) {
                throw new ValidationException(['receipt' => ['failed upload file']]);
            }
            $uploadedFiles[$file['name'][$key]] = $storagePath;
        }

        return $uploadedFiles[0];
    }


    
    
    public function deletepage()
    {
        $this->validator->deletePageValidation($_POST);
        $this->PagesModel->deletePage((int)$_POST['id'], (int)$_SESSION['user']);
        redirectTo('/');
    }

    public function followPage()
    {
        $this->validator->followPageValidation($_POST);
        $this->PagesModel->followPage((int)$_POST['page_id'] , (int)$_SESSION['user_id']);
    }
    
    public function UnfollowPage()
    {
        $this->validator->UnfollowPageValidation($_POST);
        $this->PagesModel->UnfollowPage((int)$_POST['page_id'] , (int)$_SESSION['user_id']);
    }
    
    public function PageForm()
    {
        echo $this->view->render(
            "pageForm.php",
            [
                'title' => 'PageForm | discoverify'
            ]
        );
    }
}
