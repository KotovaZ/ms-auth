<?php

namespace App\Http\Controllers;

use App\Auth\Session\SessionServiceInterface;
use Exception;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SessionRegister extends ControllerResolver
{
    public function __construct(public SessionServiceInterface $gameService)
    {
    }

    public function register(Request $request)
    {
        $bodyContent = $request->getContent();
        $data = json_decode($bodyContent, true);
        $users = $data['users'];

        if (empty($users))
            throw new Exception("Список участников не определен");

        return $this->gameService->register($users);
    }
}
