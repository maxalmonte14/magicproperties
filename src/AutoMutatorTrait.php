<?php

namespace MagicProperties;

use MagicProperties\Exceptions\InvalidPropertyCallException;

/**
 * Allow access to a setter implicitly
 */
trait AutoMutatorTrait
{
    /**
     * The properties that gonna be resolved
     * via the __set magic method
     *
     * @var array
     */
    protected $settables = [];

    /**
     * Set the value of a settable property
     *
     * @param string $prop
     * @param mixed  $value
     * @throws MagicProperties\Exceptions\InvalidPropertyCallException
     * @return void
     */
    final public function __set($prop, $value)
    {
        if (!property_exists(__CLASS__, $prop)) {
            throw new InvalidPropertyCallException(
                "You're trying to access to undefined property {$prop}.",
                InvalidPropertyCallException::UNDEFINED_PROPERTY
            );
        }
        if (in_array($prop, $this->settables)) {
            $this->callSetter($prop, $value);
        } else {
            throw new InvalidPropertyCallException(
                "Property {$prop} is not accessible out of the class.",
                InvalidPropertyCallException::NOT_ACCESSABLE_PROPERTY
            );
        }
    }

    /**
     * Call the defined setter for a settable
     * property if there's not defined a setter,
     * set the value directly
     *
     * @param  string $prop
     * @param  mixed  $value
     * @return void
     */
    private function callSetter($prop, $value)
    {
        if (method_exists(__CLASS__, toCamelCase($prop, 'set'))) {
            call_user_func_array([__CLASS__, toCamelCase($prop, 'set')], [$value]);
        } elseif (method_exists(__CLASS__, toSnakeCase($prop, 'set'))) {
            call_user_func_array([__CLASS__, toSnakeCase($prop, 'set')], [$value]);
        } else {
            $this->$prop = $value;
        }
    }
}
