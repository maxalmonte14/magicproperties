<?php

namespace Tests\Unit;

use Tests\Fakes\FakeUser;
use PHPUnit\Framework\TestCase;

class AutoAccessorTest extends TestCase
{

    private $fakeUser;

    public function setUp()
    {
        $this->fakeUser = new FakeUser('maxalmonte14');
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
        $this->expectException('MagicProperties\Exceptions\InvalidPropertyCallException');
        $this->expectExceptionMessage('Property password is not accessible out of the class.');
        $this->expectExceptionCode(2);
        $this->fakeUser->password;
    }

    /**
     * @test
     */
    public function cannotAccessToUnexistingProperty()
    {
        $this->expectException('MagicProperties\Exceptions\InvalidPropertyCallException');
        $this->expectExceptionMessage("You're trying to access to undefined property nonExistingProperty.");
        $this->expectExceptionCode(1);
        $this->fakeUser->nonExistingProperty;
    }
}
