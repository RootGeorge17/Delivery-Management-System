<?php

class AntiSpam {
    private static $randomBytes;

    public function __construct() {
        self::$randomBytes = bin2hex(random_bytes(7));
    }

    public static function getRandomBytes() {
        return self::$randomBytes;
    }
}