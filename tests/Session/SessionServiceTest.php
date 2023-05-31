<?php

namespace Tests\Unit;

use App\Auth\Session\SessionRepositoryInterface;
use App\Auth\Session\SessionService;
use App\Auth\User\UserInterface;
use App\Auth\User\UserServiceInterface;
use App\Exceptions\NotFoundException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SessionServiceTest extends TestCase
{

    public function testRegisterGame(): void
    {

        /** @var UserInterface&MockObject $user */
        $user = $this->createMock(UserInterface::class);

        /** @var UserServiceInterface&MockObject $userService */
        $userService = $this->createMock(UserServiceInterface::class);
        $userService->method('get')->willReturn($user);

        /** @var SessionRepositoryInterface&MockObject $sessionRepository */
        $sessionRepository = $this->createMock(SessionRepositoryInterface::class);
        $sessionRepository->expects($this->once())->method('save');

        $sessionService = new SessionService($userService, $sessionRepository);
        $sessionService->register(['user1', 'user2']);
    }

    public function testRegisterGameWithNotExistenUser(): void
    {
        /** @var UserServiceInterface&MockObject $userService */
        $userService = $this->createMock(UserServiceInterface::class);
        $userService->method('get')->willReturn(null);

        /** @var SessionRepositoryInterface&MockObject $sessionRepository */
        $sessionRepository = $this->createMock(SessionRepositoryInterface::class);
        $sessionRepository->expects($this->never())->method('save');

        $sessionService = new SessionService($userService, $sessionRepository);
        $this->expectException(NotFoundException::class);
        $sessionService->register(['user1', 'user2']);
    }

    public function testGetSessionById(): void
    {
        /** @var UserServiceInterface&MockObject $userService */
        $userService = $this->createMock(UserServiceInterface::class);

        /** @var SessionRepositoryInterface&MockObject $sessionRepository */
        $sessionRepository = $this->createMock(SessionRepositoryInterface::class);
        $sessionRepository->expects($this->once())->method('get')->willReturn(['user1']);

        $sessionService = new SessionService($userService, $sessionRepository);
        $sessionService->get('123');
    }

    public function testGetUndefinedSession(): void
    {
        /** @var UserServiceInterface&MockObject $userService */
        $userService = $this->createMock(UserServiceInterface::class);

        /** @var SessionRepositoryInterface&MockObject $sessionRepository */
        $sessionRepository = $this->createMock(SessionRepositoryInterface::class);
        $sessionRepository->expects($this->once())->method('get')->willReturn(null);

        $sessionService = new SessionService($userService, $sessionRepository);
        $this->expectException(NotFoundException::class);
        $sessionService->get('123');
    }

    protected function setUp(): void
    {
    }
}
