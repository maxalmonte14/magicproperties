<?php

use MagicProperties\AutoAccessorTrait;
use PHPUnit\Framework\TestCase;

class AutoAccessorTest extends TestCase{

    private $fakeUser;

    public function setUp()
    {
        $this->fakeUser = new class('maxalmonte14') {
            
            use AutoAccessorTrait;
        
            private $username;
            private $password = 'some_secure_password';
        
            public function __construct($username) 
            {
                $this->username = $username;
                $this->gettables = ['username'];
            }
        
            public function getUsername()
            {
                return sprintf('Your username is %s', $this->username);
            }
        };
    }

    /** @test */
    public function canAccessToPrivateGettableProperty()
    {
        $this->assertEquals('Your username is maxalmonte14', $this->fakeUser->username);
    }

    /** 
     * @test
     */
    public function cannotAccessToPrivateNotGettableProperty()
    {
        $this->expectException(MagicProperties\Exceptions\InvalidPropertyCallException::class);
        $this->expectExceptionMessage('Property password is not accessible out of the class.');
        $this->expectExceptionCode(2);
        $this->fakeUser->password;
    }

    /** 
     * @test
     */
    public function cannotAccessToUnexistingProperty()
    {
        $this->expectException(MagicProperties\Exceptions\InvalidPropertyCallException::class);
        $this->expectExceptionMessage("You're trying to access to undefined property nonExistingProperty.");
        $this->expectExceptionCode(1);
        $this->fakeUser->nonExistingProperty;
    }

}