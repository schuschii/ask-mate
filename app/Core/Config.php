<?php

namespace App\Core;

use Exception;

class Config
{
    private static array $config = [];

    /**
     * @throws Exception
     */
    public static function load(string $filePath): void
    {
        if (!file_exists($filePath)) {
            throw new Exception("Config file not found: " . $filePath);
        }

        // Load the main config
        $json = file_get_contents($filePath);
        self::$config = json_decode($json, true) ?? [];

        $localFile = dirname($filePath) . '/config.local.json';

        if (file_exists($localFile)) {
            $json = file_get_contents($localFile);
            $localConfig = json_decode($json, true) ?? [];
            self::$config = array_merge(self::$config, $localConfig);
        }
    }

    public static function get(string $key, $default = null)
    {
        return self::$config[$key] ?? $default;
    }
}
