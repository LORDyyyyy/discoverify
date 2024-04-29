<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Models\UserModel;
use App\Services\ValidatorService;

class AuthController
{
    private TemplateEngine $view;
    private UserModel $userModel;
    private ValidatorService $validatorService;

    public function __construct(TemplateEngine $view, UserModel $userModel, ValidatorService $validatorService)
    {
        $this->view = $view;
        $this->userModel = $userModel;
        $this->validatorService = $validatorService;
    }

    public function loginView()
    {
        // Middlewares: GuestOnlyMiddleware

        echo $this->view->render(
            'auth/login.php',
            ['title' => 'Login | Discoverify']
        );
    }

    public function login()
    {
        // Middlewares: GuestOnlyMiddleware

        $this->validatorService->validateLogin($_POST);

        $user = $this->userModel->login($_POST['email'], $_POST['password']);

        session_regenerate_id();

        $_SESSION['user'] = $user['id'];

        redirectTo('/');
    }


    public function signup()
    {
        // Middlewares: GuestOnlyMiddleware

        $this->validatorService->validateSignup($_POST);

        $this->userModel->isEmailTaken($_POST['email']);

        echo 'Signup';

        $data = $_POST;
        unset($data['confirmPassword']);
        unset($data['token']);

        $id = $this->userModel->create($data);

        if (!$id) {
            throw new \Exception('User was not created');
        }

        session_regenerate_id();

        $_SESSION['user'] = $id;

        redirectTo('/');
    }

    public function signupView()
    {
        // Middlewares: GuestOnlyMiddleware

        echo $this->view->render(
            'auth/signup.php',
            ['title' => 'Signup | Discoverify']
        );
    }

    public function logout(): void
    {
        // Middlewares: AuthRequiredMiddleware

        session_destroy();

        $params = session_get_cookie_params();

        setcookie(
            'PHPSESSID',
            '',
            time() - 3600,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );

        redirectTo('/login');
    }
}
