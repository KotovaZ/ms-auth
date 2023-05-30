<?php

namespace App\Http\Controllers;

use App\Auth\Session\SessionServiceInterface;
use App\Exceptions\BadRequest;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Illuminate\Http\Request;

class SessionLogin extends ControllerResolver
{
    public function __construct(public SessionServiceInterface $sessionService)
    {
    }

    public function login(Request $request, string $id)
    {
        $bodyContent = $request->getContent();
        $data = json_decode($bodyContent, true);

        if (!array_key_exists('login', $data) || !array_key_exists('password', $data)) {
            throw new BadRequest("Не указаны логин и пароль пользователя");
        }

        return $this->sessionService->authenticate($id, $data['login'], $data['password']);
    }
}
