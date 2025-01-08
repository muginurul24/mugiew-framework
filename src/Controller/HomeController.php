<?php

namespace Mugiew\Galeano\Controller;

use Mugiew\Galeano\App\View;

class HomeController
{
    public function index(): void
    {
        $data = [
            'title' => 'MUGIEW',
            'message' => 'A simple PHP framework for building web applications.'
        ];

        View::render('index', $data);
    }
}
