<?php

class Validator
{
    public static function validateString($value, $min = 1, $max = INF)
    {
        $string = trim($value);
        return strlen($string) >= $min && strlen($string) <= $max;
    }

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
