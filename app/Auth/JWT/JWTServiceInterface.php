<?php

namespace App\Auth\JWT;

interface JWTServiceInterface
{
    public function encode(array $payload): string;
    public function decode(string $jwt): array;
}
