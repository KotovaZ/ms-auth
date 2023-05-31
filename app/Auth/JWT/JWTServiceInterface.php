<?php

namespace App\Auth\JWT;

use stdClass;

interface JWTServiceInterface
{
    public function encode(array $payload): string;
    public function decode(string $jwt): stdClass;
}
