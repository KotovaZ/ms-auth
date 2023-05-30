<?php

namespace App\Providers;

use App\Auth\Session\SessionService;
use App\Auth\Session\SessionServiceInterface;
use App\Auth\JWT\JWTServiceInterface;
use App\Auth\JWT\RS256Service;
use App\Auth\Session\SessionRepository;
use App\Auth\Session\SessionRepositoryInterface;
use App\Auth\User\UserService;
use App\Auth\User\UserServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            JWTServiceInterface::class,
            function ($app) {
                return new RS256Service(env('JWT_PRIVATE'), env('JWT_PUBLIC'));
            }
        );

        $this->app->bind(
            UserServiceInterface::class,
            UserService::class
        );

        $this->app->bind(
            SessionServiceInterface::class,
            SessionService::class
        );

        $this->app->bind(
            SessionRepositoryInterface::class,
            SessionRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
