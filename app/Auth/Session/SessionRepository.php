<?php

namespace App\Auth\Session;

use App\Auth\User\UserServiceInterface;
use App\Exceptions\NotFoundException;
use App\Exceptions\PermissionDenied;
use Illuminate\Support\Facades\Cache;

class SessionRepository implements SessionRepositoryInterface
{
    public function get(string $id): ?array
    {
        $data = Cache::get($id);
        if (empty($data)) {
            null;
        }

        return json_decode($data, true);
    }

    public function save($players): string
    {
        $gameId = $this->guid();
        Cache::set($gameId, json_encode($players));
        return $gameId;
    }

    private function guid($data = null): string
    {
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
