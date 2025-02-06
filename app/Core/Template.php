<?php

namespace App\Core;

use eftec\bladeone\BladeOne;

class Template
{
    private static ?BladeOne $blade = null;

    public static function getInstance(): BladeOne
    {
        if (self::$blade === null) {

            $views = __DIR__ . '/../../src/views'; // Path to template files
            $cache = __DIR__ . '/../../cache'; // Path to compiled templates

            // Ensure cache directory exists
            if (!file_exists($cache)) {
                mkdir($cache, 0777, true);
            }

            // Add multiple view directories to BladeOne
            $viewPaths = [
                $views . '/tag',
                $views . '/answer',   // Path to /views/answer
                $views . '/question', // Path to /views/question
                $views                // You can also include the root /views
            ];

            self::$blade = new BladeOne($viewPaths, $cache, BladeOne::MODE_AUTO);
        }

        return self::$blade;
    }
}
