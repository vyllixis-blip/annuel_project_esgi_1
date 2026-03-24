<?php
/*
** ESGI PROJECT, 2025
** config/app.php
** File description:
** Application constants and environment settings
*/

/* ─── Environment ──────────────────────────────────────────────── */
define('APP_NAME',    'GameLib');
define('APP_TAGLINE', 'Votre Bibliothèque de Jeux Vidéo');
define('APP_VERSION', '1.0.0');
define('APP_ENV',     'development'); // 'development' | 'production'

/* ─── URL / Path helpers ───────────────────────────────────────── */
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host     = $_SERVER['HTTP_HOST'] ?? 'localhost';
define('BASE_URL',  $protocol . '://' . $host);
define('ROOT_PATH', dirname(__DIR__)); // absolute path to project root

/* ─── Session settings ─────────────────────────────────────────── */
define('SESSION_LIFETIME', 86400); // 24 h

/* ─── Pagination ───────────────────────────────────────────────── */
define('GAMES_PER_PAGE', 16);

/* ─── Error reporting ──────────────────────────────────────────── */
if (APP_ENV === 'development') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}
