<?php

namespace Tests\Fakes;

use MagicProperties\AutoMutatorTrait;
use MagicProperties\AutoAccessorTrait;

class FakeUser
{
    use AutoAccessorTrait, AutoMutatorTrait;

    private $username;
    private $password = 'some_secure_password';

    public function __construct($username)
    {
        $this->username = $username;
        $this->gettables = ['username'];
        $this->settables = ['username'];
    }

    public function getUsername()
    {
        return sprintf('Your username is %s', $this->username);
    }

    public function setUsername($val)
    {
        if (!is_string($val)) {
            throw new InvalidArgumentException('Username must be of type string');
        }
        $this->username = $val;
    }
}
