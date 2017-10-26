<?php

namespace MagicProperties\Exceptions;

use \Exception;

/**
 * Exception thrown if a class that uses
 * AutoAccessorTrait or AutoMutatorTrait
 * try to access a property in a wrong way
 */
class InvalidPropertyCallException extends Exception
{

    const UNDEFINED_PROPERTY = 1;
    const NOT_ACCESSABLE_PROPERTY = 2;

    /**
     * Return the string representation
     * of the Exception
     *
     * @return string
     */
    public function __toString()
    {
        return __CLASS__ . "'{$this->message}' in {$this->file}, ({$this->line})\n, {$this->getTraceAsString()}";
    }
}
