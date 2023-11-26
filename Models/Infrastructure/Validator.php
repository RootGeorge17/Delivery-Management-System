<?php

namespace Infrastructure;
class Validator
{
    public static function validateString($value, $min = 1, $max = INF)
    {
        $string = trim($value);
        return strlen($string) >= $min && strlen($string) <= $max;
    }
}
