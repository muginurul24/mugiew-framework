<?php

namespace Mugiew\Galeano\Controller;

use Mugiew\Galeano\App\View;
use Mugiew\Galeano\Config\Database;
use Mugiew\Galeano\Exception\ValidationException;
use Mugiew\Galeano\Model\UserLoginRequest;
use Mugiew\Galeano\Model\UserRegisterRequest;
use Mugiew\Galeano\Repository\SessionRepository;
use Mugiew\Galeano\Repository\UserRepository;
use Mugiew\Galeano\Service\SessionService;
use Mugiew\Galeano\Service\UserService;

class UserController
{
    private UserService $userService;
    private SessionService $sessionService;

    public function __construct()
    {
        $connection = Database::connect();
        $userRepository = new UserRepository($connection);
        $this->userService = new UserService($userRepository);

        $sessionRepository = new SessionRepository($connection);
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }

    public function register(): void
    {
        $data = [
            'title' => 'Register'
        ];

        View::render('Pages/Guest/register', $data);
    }

    public function postRegister()
    {
        $request = new UserRegisterRequest();
        $request->id = $_POST['id'];
        $request->username = $_POST['username'];
        $request->password = $_POST['password'];

        try {
            $this->userService->register($request);
            View::redirect('/');
        } catch (ValidationException $exception) {
            $data = [
                'title' => 'Register',
                'error' => $exception->getMessage()
            ];

            View::render('Pages/Guest/register', $data);
        }
    }

    public function postLogin()
    {
        $request = new UserLoginRequest();
        $request->id = $_POST['id'];
        $request->password = $_POST['password'];

        try {
            $response = $this->userService->login($request);
            $this->sessionService->create($response->user->id);
            View::redirect('/');
        } catch (ValidationException $exception) {
            View::render('Pages/Guest/login', [
                'title' => 'Login',
                'error' => $exception->getMessage()
            ]);
        }
    }

    public function logout(): void
    {
        $this->sessionService->destroy();
        View::redirect('/');
    }
}
