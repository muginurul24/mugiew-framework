<?php

namespace Mugiew\Galeano\Middleware;

interface Middleware
{
    public function before(): void;
}
