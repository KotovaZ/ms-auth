<?php

namespace Tests\Unit;

use App\Auth\JWT\JWTServiceInterface;
use App\Auth\User\UserService;
use App\Exceptions\BadRequest;
use App\Exceptions\NotFoundException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    public function testGetUser(): void
    {
        
        /** @var JWTServiceInterface&MockObject $jwtService */
        $jwtService = $this->createMock(JWTServiceInterface::class);
        $userService = new UserService($jwtService);

        $user = $userService->get('user1');
        $this->assertEquals('user1', $user->getLogin());
    }

    public function testAuthenticate(): void
    {
        
        /** @var JWTServiceInterface&MockObject $jwtService */
        $jwtService = $this->createMock(JWTServiceInterface::class);
        $jwtService->expects($this->once())->method('encode');

        $userService = new UserService($jwtService);
        $userService->authenticate('user1', '1234');
    }

    public function testAuthenticateNotFoundUser(): void
    {
        /** @var JWTServiceInterface&MockObject $jwtService */
        $jwtService = $this->createMock(JWTServiceInterface::class);
        $userService = new UserService($jwtService);
        $this->expectException(NotFoundException::class);
        $userService->authenticate('user12', '1234');
    }

    public function testAuthenticateWrongPassword(): void
    {
        /** @var JWTServiceInterface&MockObject $jwtService */
        $jwtService = $this->createMock(JWTServiceInterface::class);
        $userService = new UserService($jwtService);
        $this->expectException(BadRequest::class);
        $userService->authenticate('user1', '000');
    }

    protected function setUp(): void
    {
    }
}
