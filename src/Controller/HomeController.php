<?php

namespace Mugiew\Galeano\Controller;

use Mugiew\Galeano\App\View;
use Mugiew\Galeano\Config\Database;
use Mugiew\Galeano\Repository\SessionRepository;
use Mugiew\Galeano\Repository\UserRepository;
use Mugiew\Galeano\Service\SessionService;

class HomeController
{
    private SessionService $sessionService;

    public function __construct()
    {
        $connection = Database::connect();
        $sessionRepository = new SessionRepository($connection);
        $userRepository = new UserRepository($connection);
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }

    public function index(): void
    {
        $user = $this->sessionService->current();

        if ($user == null) {
            $data = [
                'title' => 'Login',
                'user' => null
            ];
        } else {
            $data = [
                'title' => 'Dashboard',
                'user' => [
                    'username' => $user->username
                ]
            ];
        }

        View::render('index', $data);
    }
}
