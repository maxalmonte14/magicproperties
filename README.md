## About MagicProperties

MagicProperties is a little but powerful package that allows you call getters and setters implicitly in all objects you want, something like C# properties or Laravel accessors and mutators (for Eloquent ORM).

## Requirements

```
PHP >= 7.0
```

## Installation

```
composer require "maxalmonte14/magicproperties"
```

## Examples

Let's begin! with MagicProperties you can access to your getters and setters in a transparent way without exposing your business logic. First, use the traits in your class.

```php
use MagicProperties\AutoAccessorTrait, AutoMutatorTrait;

class User {
    use AutoAccessorTrait, AutoMutatorTrait;

    private $username;
    private $token;
}
```

> **Note**: The AutoAccessorTrait and AutoMutatorTrait use the __get and __set PHP magic methods, if you're using it in your class you gonna receive some error for sure, so don't do that!

Step two define your gettables and settables in the constructor.

```php
public function __construct()
{
    $this->gettables = ['username'];
    $this->settables = ['username'];
}
```

Step three, define your own getters and setters for your gettables and settables.

```php
public function getUsername()
{
    return strtolower($this->username);
}

public function setUsername($newUsername)
{
    $this->username = strtoupper($newUsername);
}
```

> **Note**: You have to define your getters and setters following the convention "get + property name" and "set + property name", otherwise the property it's gonna set or get without calling any method. You can name your methods either camel case or snake case, anyway, it's gonna work!

The final step, enjoy calling your properties!

```php
$user = new User();
$user->username = 'MaxAlmonte14'; // The value is set to MAXALMONTE14
echo $user->username; // Returns maxalmonte14
```

> **Note**: Take care about this, the package doesn't make available all your private properties to the public context, only the properties defined in the gettables and settables array are gonna be accessible, so, if you try to access to a private non-gettable/settable property an exception is gonna be thrown.

```php
echo $user->token; // An InvalidPropertyCallException is thrown!
```