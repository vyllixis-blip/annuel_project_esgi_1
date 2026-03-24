<?php
/*
** ESGI PROJECT, 2025
** config/database.php
** File description:
** PDO database connection singleton
*/

require_once __DIR__ . '/app.php';

class Database
{
    private static ?PDO $instance = null;

    /* ─── Database credentials ─────────────────────────────────── */
    private const HOST   = '127.0.0.1';
    private const PORT   = '3306';
    private const NAME   = 'gamelib';
    private const USER   = 'root';
    private const PASS   = '';
    private const CHARSET= 'utf8mb4';

    private function __construct() {}
    private function __clone() {}

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=%s',
                self::HOST, self::PORT, self::NAME, self::CHARSET
            );
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            try {
                self::$instance = new PDO($dsn, self::USER, self::PASS, $options);
            } catch (PDOException $e) {
                /* In dev, bubble the exception. In prod, show a generic error. */
                if (APP_ENV === 'development') {
                    throw $e;
                }
                die('Erreur de connexion à la base de données.');
            }
        }
        return self::$instance;
    }
}

/* Convenience alias */
function db(): PDO
{
    return Database::getInstance();
}
