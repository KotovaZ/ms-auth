<?php

namespace App\Auth\User;

interface UserServiceInterface
{
    public function authenticate(string $login, string $password, array $initialPayload = []): string;
    public function get(string $login): ?UserInterface;
}
