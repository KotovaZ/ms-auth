<?php

namespace App\Auth\User;

class User implements UserInterface
{
    public function __construct(private array $data)
    {
    }

    public function getName(): string
    {
        return $this->data['name'];
    }

    public function setName(string $name): self
    {
        $this->data['name'] = $name;

        return $this;
    }

    public function getLogin(): string
    {
        return $this->data['login'];
    }

    public function setLogin(string $login): self
    {
        $this->data['login'] = $login;

        return $this;
    }
}
