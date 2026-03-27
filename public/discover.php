<?php
/**
 * Entry Point: Discovery Page
 * public/discover.php
 */

require_once __DIR__ . '/../bootstrap.php';

// Load helpers
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

// Récupérer le contrôleur depuis le bootstrap
$discoveryController = $GLOBALS['discoveryController'];

// Préparer les variables pour la vue
$pageTitle = 'Découvrez votre Jeu';
$activeNav = 'discover';

// Récupérer les données filtrées
$data = $discoveryController->index();
$games = $data['games'] ?? [];
$difficulties = $data['filters']['difficulties'] ?? [];
$graphics_styles = $data['filters']['graphics_styles'] ?? [];
$audiences = $data['filters']['audiences'] ?? [];
$selected = $data['filters']['selected'] ?? [];
$pagination = $data['pagination'] ?? [];

$difficulty = $selected['difficulty'] ?? '';
$graphics = $selected['graphics'] ?? '';
$audience = $selected['audience'] ?? '';
$q = $selected['query'] ?? '';
$sort = $selected['sort'] ?? 'rating';

// Formater la pagination pour la vue
$paginated = [
    'items' => $games,
    'page' => $pagination['page'] ?? 1,
    'pages' => $pagination['totalPages'] ?? 1,
    'total' => $pagination['totalGames'] ?? 0,
    'perPage' => $pagination['perPage'] ?? 12,
];

// Capturer le contenu de la vue
ob_start();
include_once __DIR__ . '/../resources/views/discover.php';
$content = ob_get_clean();

// Afficher le layout avec le contenu
include_once __DIR__ . '/../resources/layouts/base.php';
