<?php

/**
 * Class AntiSpam
 *
 * Represents functionality related to anti-spam measures.
 */
class AntiSpam {
    /**
     * @var string Holds the generated random bytes.
     */
    private static $randomBytes;

    /**
     * AntiSpam constructor.
     *
     * Initializes the random bytes.
     */
    public function __construct() {
        self::$randomBytes = bin2hex(random_bytes(7));
    }

    /**
     * Retrieves the generated random bytes.
     *
     * @return string The random bytes.
     */
    public static function getRandomBytes() {
        return self::$randomBytes;
    }
}
