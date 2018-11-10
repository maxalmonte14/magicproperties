<?php

namespace MagicProperties;

use MagicProperties\Exceptions\InvalidPropertyCallException;

/**
 * Allow access to a setter implicitly
 */
trait AutoMutatorTrait
{
    /**
     * The properties that will be resolved
     * via the __set magic method.
     *
     * @var array
     */
    protected $settables = [];

    /**
     * Sets the value of a settable property.
     *
     * @param string $property
     * @param mixed  $value
     *
     * @throws MagicProperties\Exceptions\InvalidPropertyCallException
     *
     * @return void
     */
    final public function __set($property, $value)
    {
        if (!property_exists($this, $property)) {
            throw new InvalidPropertyCallException(
                "You're trying to access to undefined property {$property}.",
                InvalidPropertyCallException::UNDEFINED_PROPERTY
            );
        }

        if (!in_array($property, $this->settables)) {
            throw new InvalidPropertyCallException(
                "Property {$property} is not accessible out of the class.",
                InvalidPropertyCallException::NOT_ACCESSABLE_PROPERTY
            );
        }

        $this->callSetter($property, $value);
    }

    /**
     * Calls the defined setter for a settable
     * property if there's not defined a setter,
     * sets the value directly.
     *
     * @param string $property
     * @param mixed  $value
     *
     * @return void
     */
    private function callSetter($property, $value)
    {
        if (method_exists($this, toCamelCase($property, 'set'))) {
            call_user_func_array([$this, toCamelCase($property, 'set')], [$value]);
        }

        if (method_exists($this, toSnakeCase($property, 'set'))) {
            call_user_func_array([$this, toSnakeCase($property, 'set')], [$value]);
        }

        $this->$property = $value;
    }
}
