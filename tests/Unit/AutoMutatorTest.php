<?php

namespace Tests\Unit;

use Tests\Fakes\FakeUser;
use PHPUnit\Framework\TestCase;

class AutoMutatorTest extends TestCase
{
    private $fakeUser;

    public function setUp()
    {
        $this->fakeUser = new FakeUser('maxalmonte14');
    }

    /** @test */
    public function it_can_mutate_a_private_settable_property()
    {
        $this->fakeUser->username = 'php_boy';
        $this->assertEquals('Your username is php_boy', $this->fakeUser->username);
    }

    /** @test */
    public function it_can_not_mutate_private_not_settable_property()
    {
        $this->expectException('MagicProperties\Exceptions\InvalidPropertyCallException');
        $this->expectExceptionMessage('Property password is not accessible out of the class.');
        $this->expectExceptionCode(2);
        $this->fakeUser->password = 'new_password';
    }

    /** @test */
    public function it_can_not_mutate_an_unexisting_property()
    {
        $this->expectException('MagicProperties\Exceptions\InvalidPropertyCallException');
        $this->expectExceptionMessage('You\'re trying to access to undefined property nonExistingProperty.');
        $this->expectExceptionCode(1);
        $this->fakeUser->nonExistingProperty = 'some value';
    }
}
