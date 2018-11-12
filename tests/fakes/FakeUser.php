<?php

namespace Tests\Fakes;

use MagicProperties\AutoAccessorTrait;
use MagicProperties\AutoMutatorTrait;

class FakeUser
{
    use AutoAccessorTrait, AutoMutatorTrait;

    private $password;

    private $token;

    private $username;

    public function __construct($username)
    {
        $this->username = $username;
        $this->token = 'auto_generated_token';
        $this->password = 'some_secure_password';
        $this->gettables = ['username'];
        $this->settables = ['username'];
    }

    public function getToken()
    {
        return strtoupper($this->token);
    }

    public function getUsername()
    {
        return sprintf('Your username is %s', $this->username);
    }

    public function setUsername($username)
    {
        if (!is_string($username)) {
            throw new InvalidArgumentException('Username must be of type string');
        }

        $this->username = $username;
    }
}
