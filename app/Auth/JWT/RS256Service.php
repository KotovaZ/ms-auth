<?php

namespace App\Auth\JWT;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use stdClass;

class RS256Service implements JWTServiceInterface
{
    public function __construct(private string $privateKey, private string $publicKey)
    {
    }

    public function encode(array $payload): string
    {
        return JWT::encode($payload, $this->privateKey, 'RS256');
    }

    public function decode(string $jwt): stdClass
    {
        return JWT::decode($jwt, new Key($this->publicKey, 'RS256'));
    }
}
