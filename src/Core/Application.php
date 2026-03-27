<?php

namespace GameLib\Core;

/**
 * Application Core - Bootstrap and Configuration
 *
 * @package GameLib\Core
 * @author ESGI Project Team
 * @version 1.0.0
 */
class Application
{
    private static string $_baseDir;
    private static string $_basePath;

    /**
     * Initialize the application
     */
    public static function bootstrap(string $baseDir): void
    {
        self::$_baseDir = rtrim($baseDir, DIRECTORY_SEPARATOR);
        
        // Determine base path safely
        $scheme = $_SERVER['REQUEST_SCHEME'] ?? 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        self::$_basePath = $scheme . '://' . $host;

        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Get base directory
     */
    public static function getBaseDir(): string
    {
        return self::$_baseDir;
    }

    /**
     * Get path to directory
     */
    public static function path(string $relative = ''): string
    {
        return self::$_baseDir . DIRECTORY_SEPARATOR . ltrim($relative, DIRECTORY_SEPARATOR);
    }

    /**
     * Get base URL path
     */
    public static function basePath(): string
    {
        return self::$_basePath;
    }

    /**
     * Get URL
     */
    public static function url(string $path = ''): string
    {
        return self::$_basePath . '/' . ltrim($path, '/');
    }
}
