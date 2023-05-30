<?php

namespace App\Auth\Session;

use App\Auth\User\UserServiceInterface;
use App\Exceptions\NotFoundException;
use App\Exceptions\PermissionDenied;

class SessionService implements SessionServiceInterface
{
    public function __construct(private UserServiceInterface $userService, private SessionRepositoryInterface $sessionRepository)
    {
    }

    public function register(array $users): string
    {
        foreach ($users as $login) {
            $user = $this->userService->get($login);
            if (empty($user))
                throw new NotFoundException("Пользователь не зарегистрирован в системе");
        }

        return $this->saveSession($users);
    }

    public function get(string $id): array
    {
        $data = $this->sessionRepository->get($id);
        if (empty($data)) {
            throw new NotFoundException("Сессия не зарегистрирована");
        }

        return $data;
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
        return $this->sessionRepository->save($players);
    }
}
