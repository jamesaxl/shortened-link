<?php
/**
 *
 * I rewrite the class Hash we do not know in the future
 *
 */

namespace App\Utils;
use Illuminate\Support\Facades\Hash as LaraHash;

class Hash
{
    /**
     * @param string $password
     * @return string
     */
    public static function make(string $password): string
    {
        return LaraHash::make($password);
    }

    /**
     * @param string $password
     * @param string $hashedPassword
     * @return bool
     */
    public static function check(string $password, string $hashedPassword): bool
    {
        return LaraHash::check($password, $hashedPassword);
    }

    /**
     * @param string $hashedPassword
     * @return bool
     */
    public static function needsRehash(string $hashedPassword): bool
    {
        return LaraHash::needsRehash($hashedPassword);
    }
}
