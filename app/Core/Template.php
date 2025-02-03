<?php

namespace App\Core;

use eftec\bladeone\BladeOne;

class Template
{
    private static ?BladeOne $blade = null;

    public static function getInstance(): BladeOne
    {
        if (self::$blade === null) {
            $views = __DIR__ . '/../../views'; // Path to template files
            $cache = __DIR__ . '/../../cache'; // Path to compiled templates

            // Ensure cache directory exists
            if (!file_exists($cache)) {
                mkdir($cache, 0777, true);
            }

            self::$blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);
        }

        return self::$blade;
    }
}
