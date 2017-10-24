<?php

use MagicProperties\AutoMutatorTrait;
use MagicProperties\AutoAccessorTrait;
use PHPUnit\Framework\TestCase;

class AutoMutatorTest extends TestCase{

    private $fakeUser;

    public function setUp()
    {
        $this->fakeUser = new class('maxalmonte14') {
            
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
                if (!is_string($val))
                    throw new InvalidArgumentException('Username must be of type string');
                $this->username = $val;
            }
        };
    }

    /** @test */
    public function canMutatePrivateSettableProperty()
    {
        $this->fakeUser->username = 'php_boy';
        $this->assertEquals('Your username is php_boy', $this->fakeUser->username);
    }

    /** 
     * @test 
     */
    public function cannotMutatePrivateNotSettableProperty()
    {
        $this->expectException(MagicProperties\Exceptions\InvalidPropertyCallException::class);
        $this->expectExceptionMessage('Property password is not accessible out of the class.');
        $this->expectExceptionCode(2);
        $this->fakeUser->password = 'new_password';
    }

    /** 
     * @test
     */
    public function cannotMutateAnUnexistingProperty()
    {
        $this->expectException(MagicProperties\Exceptions\InvalidPropertyCallException::class);
        $this->expectExceptionMessage("You're trying to access to undefined property nonExistingProperty.");
        $this->expectExceptionCode(1);
        $this->fakeUser->nonExistingProperty = 'some value';
    }
}