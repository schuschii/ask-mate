<?php

namespace App\Core;

class SuperGlobalManager
{
    /**
     * Get data from $_REQUEST super global.
     *
     * @param string $key The key of the request parameter.
     * @param mixed $default The default value to return if the key doesn't exist.
     * @return mixed
     */
    public static function getRequest(string $key, $default = null)
    {
        return isset($_REQUEST[$key]) ? $_REQUEST[$key] : $default;
    }

    /**
     * Set data to the $_REQUEST super global.
     *
     * @param string $key The key of the request parameter.
     * @param mixed $value The value to set for the parameter.
     * @return void
     */
    public static function setRequest(string $key, $value): void
    {
        $_REQUEST[$key] = $value;
    }

    /**
     * Get data from $_SESSION super global.
     *
     * @param string $key The key of the session parameter.
     * @param mixed $default The default value to return if the key doesn't exist.
     * @return mixed
     */
    public static function getSession(string $key, $default = null)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }

    /**
     * Set data to the $_SESSION super global.
     *
     * @param string $key The key of the session parameter.
     * @param mixed $value The value to set for the session parameter.
     * @return void
     */
    public static function setSession(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Check if a key exists in $_REQUEST.
     *
     * @param string $key The key to check.
     * @return bool
     */
    public static function hasRequest(string $key): bool
    {
        return isset($_REQUEST[$key]);
    }

    /**
     * Check if a key exists in $_SESSION.
     *
     * @param string $key The key to check.
     * @return bool
     */
    public static function hasSession(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Remove a key from $_SESSION.
     *
     * @param string $key The key to remove.
     * @return void
     */
    public static function removeSession(string $key): void
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
}
