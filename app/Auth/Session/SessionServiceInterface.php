<?php

namespace App\Auth\Session;

interface SessionServiceInterface
{
    public function register(array $players): string;
    public function authenticate(string $sessionId, string $login, string $password): string;
    public function get(string $id): ?array;
}
