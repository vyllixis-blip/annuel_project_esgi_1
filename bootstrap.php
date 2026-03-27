<?php

/**
 * GameLib Application Bootstrap
 *
 * This file initializes the entire application with proper
 * configuration, autoloading, and dependency setup.
 *
 * @author ESGI Project Team
 * @version 1.0.0
 */

// Define base directory
define('GAMELIB_BASE_DIR', __DIR__);
define('GAMELIB_SRC_DIR', GAMELIB_BASE_DIR . '/src');
define('GAMELIB_DATABASE_DIR', GAMELIB_BASE_DIR . '/database');
define('GAMELIB_STORAGE_DIR', GAMELIB_BASE_DIR . '/storage');
define('GAMELIB_CONFIG_DIR', GAMELIB_BASE_DIR . '/config');

// PSR-4 Autoloader
spl_autoload_register(function (string $class) {
    // Define the base namespaces
    $prefix = 'GameLib\\';
    $baseDir = GAMELIB_SRC_DIR . '/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load environment configuration
require_once GAMELIB_CONFIG_DIR . '/app.php';

// Initialize services
use GameLib\Core\Application;
use GameLib\Services\CsvRepository;
use GameLib\Services\GameService;
use GameLib\Controllers\DiscoveryController;
use GameLib\Controllers\GameDetailController;

Application::bootstrap(GAMELIB_BASE_DIR);

// Load games from CSV
$repository = new CsvRepository(GAMELIB_DATABASE_DIR . '/games.csv');
$games = $repository->loadAll();
$gameService = new GameService($games);

// Boot application - make services available globally
$GLOBALS['gameService'] = $gameService;
$GLOBALS['discoveryController'] = new DiscoveryController($gameService);
$GLOBALS['gameDetailController'] = new GameDetailController($gameService);
