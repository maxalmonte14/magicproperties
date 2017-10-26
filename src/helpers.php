<?php

/**
 * Return the camel case version
 * of a given string
 *
 * @param  string $string
 * @return string
 */
function toCamelCase($string, $prefix = null)
{
    return is_null($prefix) ? ucfirst($string) : sprintf('%s%s', $prefix, ucfirst($string));
}

/**
 * Return the snake case version
 * of a given string
 *
 * @param  string $string
 * @return string
 */
function toSnakeCase($string, $prefix = null)
{
    return is_null($prefix) ? strtolower($string) : sprintf('%s_%s', $prefix, strtolower($string));
}
