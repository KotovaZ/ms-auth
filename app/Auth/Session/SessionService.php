<?php

namespace App\Auth\Session;

use App\Auth\User\UserServiceInterface;
use App\Exceptions\NotFoundException;
use App\Exceptions\PermissionDenied;
use Illuminate\Support\Facades\Cache;

class SessionService implements SessionServiceInterface
{
    public function __construct(private UserServiceInterface $userService)
    {
    }

    public function register(array $users): string
    {
        foreach ($users as $login) {
            $user = $this->userService->get($login);
            if (empty($user))
                throw new NotFoundException("ПОльзователь не зарегистрирован в системе");
        }

        return $this->saveSession($users);
    }

    public function get(string $id): array
    {
        $data = Cache::get($id);
        if (empty($data)) {
            throw new NotFoundException("Сессия не зарегистрирована");
        }

        return json_decode($data, true);
    }


    public function authenticate(string $sessionId, string $login, string $password): string
    {
        $sessionUsers = $this->get($sessionId);
        if (!in_array($login, $sessionUsers)) {
            throw new PermissionDenied("Доступ запрещен");
        }

        return $this->userService->authenticate($login, $password, ['session' => $sessionId]);
    }

    private function saveSession($players): string
    {
        $gameId = $this->guid();
        Cache::set($gameId, json_encode($players));
        return $gameId;
    }

    private function guid($data = null): string
    {
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
