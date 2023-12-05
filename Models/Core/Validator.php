<?php

/**
 * Class Validator
 * Contains methods to validate strings and numeric values.
 */
class Validator
{
    /**
     * Validates a string based on its length.
     *
     * @param string $value The string value to be validated.
     * @param int $min The minimum length of the string (default: 1).
     * @param int $max The maximum length of the string (default: INF).
     * @return bool Returns true if the string length is within the specified range, false otherwise.
     */
    public static function validateString($value, $min = 1, $max = INF)
    {
        $string = trim($value);
        return strlen($string) >= $min && strlen($string) <= $max;
    }

    /**
     * Validates whether a value is numeric.
     *
     * @param mixed $value The value to be validated.
     * @return bool Returns true if the value is a numeric string or numeric, false otherwise.
     */
    public static function isNumeric($value)
    {
        // Check if the value is a string or not numeric
        if (!is_numeric($value)) {
            return false;
        }

        // Check if the value matches the pattern for integer or float
        if (!preg_match('/^[-+]?\d*\.?\d+$/', $value)) {
            return false;
        }

        return true;
    }
}

