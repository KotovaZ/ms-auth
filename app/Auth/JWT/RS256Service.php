<?php

namespace App\Auth\JWT;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class RS256Service implements JWTServiceInterface
{
    public function __construct()
    {
    }

    public function encode(array $payload): string
    {
        return JWT::encode($payload, env('JWT_PRIVATE'), 'RS256');
    }

    public function decode(string $jwt): array
    {
        return JWT::decode($jwt, new Key(env('JWT_PUBLIC'), 'RS256'));
    }
}
