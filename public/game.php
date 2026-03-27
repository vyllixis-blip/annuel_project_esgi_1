<?php
/**
 * Game Detail Entry Point
 * public/game.php
 */

require_once __DIR__ . '/../bootstrap.php';

// Load helpers first
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

$gameId = (int)($_GET['id'] ?? 0);
$controller = $GLOBALS['gameDetailController'];
$data = $controller->show($gameId);

// Handle error
if (isset($data['error'])) {
    http_response_code(404);
    $pageTitle = 'Jeu non trouvé';
    $activeNav = 'discover';
    
    ob_start();
    include_once __DIR__ . '/../resources/views/game-not-found.php';
    $content = ob_get_clean();
    
    include_once __DIR__ . '/../resources/layouts/base.php';
    exit;
}

// Set template variables
$pageTitle = $data['game']->getTitle() . ' — Détails';
$activeNav = 'discover';
$game = $data['game'];

// Capturer le contenu de la vue
ob_start();
include_once __DIR__ . '/../resources/views/game-detail.php';
$content = ob_get_clean();

// Afficher le layout
include_once __DIR__ . '/../resources/layouts/base.php';
