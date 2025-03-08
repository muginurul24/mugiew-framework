<?php

namespace Mugiew\Galeano\Middleware;

use Mugiew\Galeano\App\View;
use Mugiew\Galeano\Config\Database;
use Mugiew\Galeano\Service\SessionService;
use Mugiew\Galeano\Repository\UserRepository;
use Mugiew\Galeano\Repository\SessionRepository;

class GuestMiddleware implements Middleware
{
    private SessionService $sessionService;

    public function __construct()
    {
        $sessionRepository = new SessionRepository(Database::connect());
        $userRepository = new UserRepository(Database::connect());
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }

    public function before(): void
    {
        $user = $this->sessionService->current();

        if ($user != null) {
            View::redirect('/');
        }
    }
}
