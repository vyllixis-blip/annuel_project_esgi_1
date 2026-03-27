<?php
/**
 * Main Entry Point
 * Roots all requests to appropriate controllers
 */

// Start output buffering for cleaner headers
ob_start();

// Determine the requested path
$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$basePath = '/';
$relativePath = str_replace($basePath, '', $requestPath);

// Route resolution
$routeMap = [
    'discover' => 'public/discover.php',
    'game' => 'public/game.php',
    'games' => 'pages/games.php',
    'categories' => 'pages/categories.php',
    'collections' => 'pages/collections.php',
    'login' => 'pages/login.php',
    'register' => 'pages/register.php',
    'profile' => 'pages/profile.php',
    'about' => 'pages/about.php',
    'privacy' => 'pages/privacy.php',
    'terms' => 'pages/terms.php',
    'contact' => 'pages/contact.php',
    'logout' => 'logout.php',
];

// Get the first path segment
$segments = explode('/', trim($relativePath, '/'));
$route = $segments[0] ?? 'index';

// If no route or root, use index.php
if (empty($route) || $route === 'index') {
    include __DIR__ . '/index.php';
} elseif (isset($routeMap[$route])) {
    include __DIR__ . '/' . $routeMap[$route];
} else {
    // 404 - not found
    http_response_code(404);
    include __DIR__ . '/pages/404.php';
}

ob_end_flush();
