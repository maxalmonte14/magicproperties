<?php

namespace MagicProperties;

use MagicProperties\Exceptions\InvalidPropertyCallException;

/**
 * Allows access to a getter method implicitly.
 */
trait AutoAccessorTrait
{
    /**
     * The properties that will be resolved
     * via the __get magic method.
     *
     * @var array
     */
    protected $gettables = [];

    /**
     * Gets the value of a gettable property.
     *
     * @param string $property
     *
     * @throws \MagicProperties\Exceptions\InvalidPropertyCallException
     *
     * @return void
     */
    final public function __get($property)
    {
        if (!property_exists($this, $property)) {
            throw new InvalidPropertyCallException(
                "You're trying to access to undefined property {$property}.",
                InvalidPropertyCallException::UNDEFINED_PROPERTY
            );
        }

        $getter = $this->getGetterName($property);

        if (!in_array($property, $this->gettables) && is_null($getter)) {
            throw new InvalidPropertyCallException(
                "Property {$property} is not accessible out of the class.",
                InvalidPropertyCallException::NOT_ACCESSABLE_PROPERTY
            );
        }

        return $this->callGetter($getter, $property);
    }

    /**
     * Calls the defined getter for a gettable
     * property if there's not defined a getter,
     * gets the value directly.
     *
     * @param string $getter
     * @param string $property
     *
     * @return mixed
     */
    private function callGetter($getter, $property)
    {
        if (!is_null($getter)) {
            return call_user_func([$this, $getter], $property);
        }

        return $this->$property;
    }

    /**
     * Returns the getter name for a
     * property or null if there is
     * no defined getter method.
     *
     * @param string $property
     *
     * @return string|null
     */
    private function getGetterName($property)
    {
        if (method_exists($this, toCamelCase($property, 'get'))) {
            return toCamelCase($property, 'get');
        }

        if (method_exists($this, toSnakeCase($property, 'get'))) {
            return toSnakeCase($property, 'get');
        }

        return null;
    }
}
