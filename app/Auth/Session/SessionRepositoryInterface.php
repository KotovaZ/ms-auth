<?php

namespace App\Auth\Session;

interface SessionRepositoryInterface
{
    public function save(array $players): string;
    public function get(string $id): ?array;
}
