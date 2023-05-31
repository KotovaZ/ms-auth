<?php

namespace App\Auth\User;

interface UserInterface
{
    public function getName(): string;

    public function setName(string $name): self;

    public function getLogin(): string;

    public function setLogin(string $login): self;
}
