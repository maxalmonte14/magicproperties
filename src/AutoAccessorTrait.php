<?php

namespace MagicProperties;

use MagicProperties\Exceptions\InvalidPropertyCallException;

/**
 * Allow access to a getter implicitly
 */
trait AutoAccessorTrait
{
    /**
     * The properties that gonna be resolved
     * via the __get magic method
     *
     * @var array
     */
    protected $gettables = [];

    /**
     * Get the value of a gettable property
     *
     * @param string $prop
     * @throws MagicProperties\Exceptions\InvalidPropertyCallException
     * @return void
     */
    final public function __get($prop)
    {
        if (!property_exists(__CLASS__, $prop)) {
            throw new InvalidPropertyCallException(
                "You're trying to access to undefined property {$prop}.",
                InvalidPropertyCallException::UNDEFINED_PROPERTY
            );
        }

        if (in_array($prop, $this->gettables)) {
            return $this->callGetter($prop);
        }

        throw new InvalidPropertyCallException(
            "Property {$prop} is not accessible out of the class.",
            InvalidPropertyCallException::NOT_ACCESSABLE_PROPERTY
        );
    }

    /**
     * Call the defined getter for a gettable
     * property if there's not defined a getter,
     * get the value directly
     *
     * @param  string $prop
     * @return mixed
     */
    private function callGetter($prop)
    {
        if (method_exists(__CLASS__, toCamelCase($prop, 'get'))) {
            return call_user_func([__CLASS__, toCamelCase($prop, 'get')]);
        } elseif (method_exists(__CLASS__, toSnakeCase($prop, 'get'))) {
            return call_user_func([__CLASS__, toSnakeCase($prop, 'get')]);
        }
        
        return $this->$prop;
    }
}
