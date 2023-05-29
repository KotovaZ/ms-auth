<?php

namespace App\Auth\User;

use App\Auth\JWT\JWTServiceInterface;
use App\Exceptions\BadRequest;
use App\Exceptions\NotFoundException;

class UserService implements UserServiceInterface
{
    private array $userList = [
        'user1' => [
            'pass' => '1234',
            'name' => 'Peter'
        ],
        'user2' => [
            'pass' => '1111',
            'name' => 'John'
        ],
        'user3' => [
            'pass' => '0000',
            'name' => 'Joey'
        ]
    ];

    public function __construct(private JWTServiceInterface $jwtService)
    {
    }

    public function authenticate(string $login, string $password): string
    {
        if (!isset($this->userList[$login])) {
            throw new NotFoundException("Пользоватлеь не найден", 404);
        }

        if ($this->userList[$login]['pass'] !== $password) {
            throw new BadRequest("Неверный пароль", 400);
        }

        return $this->jwtService->encode($this->getJwtPayload($login));
    }

    private function getJwtPayload(string $login): array
    {
        return [
            'username' => $this->userList[$login]['name']
        ];
    }
}
