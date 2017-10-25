<?php

use PHPUnit\Framework\TestCase;

class AutoMutatorTest extends TestCase{

    private $fakeUser;

    public function setUp()
    {
        $this->fakeUser = new FakeUser('maxalmonte14');
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
        $this->expectException('MagicProperties\Exceptions\InvalidPropertyCallException');
        $this->expectExceptionMessage('Property password is not accessible out of the class.');
        $this->expectExceptionCode(2);
        $this->fakeUser->password = 'new_password';
    }

    /** 
     * @test
     */
    public function cannotMutateAnUnexistingProperty()
    {
        $this->expectException('MagicProperties\Exceptions\InvalidPropertyCallException');
        $this->expectExceptionMessage("You're trying to access to undefined property nonExistingProperty.");
        $this->expectExceptionCode(1);
        $this->fakeUser->nonExistingProperty = 'some value';
    }
}