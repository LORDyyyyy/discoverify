<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Models\UserModel;
use App\Services\ValidatorService;
use Framework\Exceptions\ValidationException;

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

    // POST : /login
    public function login()
    {
        // Middlewares: GuestOnlyMiddleware

        $this->validatorService->validateLogin($_POST);

        $user = $this->userModel->login($_POST['email'], $_POST['password']);

        unset($_SESSION['email']);
        unset($_SESSION['code']);

        session_regenerate_id();

        $_SESSION['user'] = $user['id'];

        redirectTo('/');
    }


    public function signup()
    {
        // Middlewares: GuestOnlyMiddleware

        $this->validatorService->validateSignup($_POST);

        $this->userModel->isEmailTaken($_POST['email']);

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

    public function forgotPassView()
    {
        // Middlewares: GuestOnlyMiddleware

        echo $this->view->render(
            'auth/forgotpass.php',
            ['title' => 'Forgot Password | Discoverify']
        );
    }

    public function forgotPass()
    {
        // Middlewares: GuestOnlyMiddleware

        $this->validatorService->validateForgotPass($_POST);

        //$code = $this->email->sendResetCode($_POST['email']);
        $result = $this->userModel->emailExists($_POST['email']);

        if (!$result) {
            throw new ValidationException([
                'email' => ['Email does not exist']
            ]);
        }

        $_SESSION['email'] = $_POST['email'];
        $_SESSION['code'] = '123';

        redirectTo('/verifycode');
    }

    public function verifycodeView($token)
    {
        // Middlewares: GuestOnlyMiddleware

        echo $this->view->render(
            'auth/verify_code.php',
            ['title' => 'Verify Code | Discoverify']
        );
    }

    public function verifycode()
    {
        // Middlewares: GuestOnlyMiddleware

        $this->validatorService->validateVerifyCode($_POST);

        // dummy code
        if ($_POST['code'] !== $_SESSION['code']) {
            throw new ValidationException([
                'code' => ['Invalid code']
            ]);
        }

        redirectTo('/resetpass');
    }

    public function resetPassView()
    {
        // Middlewares: GuestOnlyMiddleware

        if (!isset($_SESSION['email']) || !isset($_SESSION['code'])) {
            redirectTo('/forgotpass');
        }

        echo $this->view->render(
            'auth/reset_pass.php',
            ['title' => 'Reset Password | Discoverify']
        );
    }

    public function resetPass()
    {
        // Middlewares: GuestOnlyMiddleware

        $this->validatorService->validateResetPass($_POST);

        $this->userModel->resetPassword($_SESSION['email'], $_POST['newPassword']);

        unset($_SESSION['email']);
        unset($_SESSION['code']);

        session_regenerate_id();

        redirectTo('/login');
    }
}
