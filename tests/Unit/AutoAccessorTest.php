<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Tests\Fakes\FakeUser;

class AutoAccessorTest extends TestCase
{
    private $fakeUser;

    public function setUp()
    {
        $this->fakeUser = new FakeUser('maxalmonte14');
    }

    /** @test */
    public function it_can_access_to_private_gettable_property()
    {
        $this->assertEquals('Your username is maxalmonte14', $this->fakeUser->username);
    }

    /** @test */
    public function it_cannot_access_to_private_not_gettable_property()
    {
        $this->expectException('MagicProperties\Exceptions\InvalidPropertyCallException');
        $this->expectExceptionMessage('Property password is not accessible out of the class.');
        $this->expectExceptionCode(2);
        $this->fakeUser->password;
    }

    /**
     * @test
     */
    public function it_cannot_access_to_unexisting_property()
    {
        $this->expectException('MagicProperties\Exceptions\InvalidPropertyCallException');
        $this->expectExceptionMessage("You're trying to access to undefined property nonExistingProperty.");
        $this->expectExceptionCode(1);
        $this->fakeUser->nonExistingProperty;
    }

    /** @test */
    public function it_can_access_to_autoregistered_private_property()
    {
        $this->assertEquals('AUTO_GENERATED_TOKEN', $this->fakeUser->token);
    }
}
