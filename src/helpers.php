<?php

/**
 * Returns the camel case version
 * of a given string.
 *
 * @param string      $string
 * @param string|null $prefix
 *
 * @return string
 */
function toCamelCase($string, $prefix = null)
{
    return is_null($prefix) ? ucfirst($string) : sprintf('%s%s', $prefix, ucfirst($string));
}

/**
 * Returns the snake case version
 * of a given string.
 *
 * @param string      $string
 * @param string|null $prefix
 *
 * @return string
 */
function toSnakeCase($string, $prefix = null)
{
    return is_null($prefix) ? strtolower($string) : sprintf('%s_%s', $prefix, strtolower($string));
}
