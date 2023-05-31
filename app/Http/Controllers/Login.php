<?php

namespace App\Http\Controllers;

use App\Auth\User\UserServiceInterface;
use App\Exceptions\BadRequest;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Illuminate\Http\Request;

class Login extends ControllerResolver
{
    public function __construct(public UserServiceInterface $userService)
    {
    }

    public function getJWT(Request $request)
    {
        $bodyContent = $request->getContent();
        $data = json_decode($bodyContent, true);

        if (!array_key_exists('login', $data) || !array_key_exists('password', $data)) {
            throw new BadRequest("Не указаны логин и пароль пользователя");
        }

        return $this->userService->authenticate($data['login'], $data['password']);
    }
}
