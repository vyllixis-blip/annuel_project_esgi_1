<?php
/*
** ESGI PROJECT, 2025
** includes/header.php
** File description:
** Shared HTML head + navbar — included by every page
*/

/* Bootstrap config + helpers if not already loaded */
$_root = dirname(__DIR__);
if (!defined('APP_NAME'))        require_once $_root . '/config/app.php';
if (!function_exists('isLoggedIn')) require_once $_root . '/includes/auth.php';
if (!function_exists('e'))       require_once $_root . '/includes/functions.php';

/* Page-level vars with safe defaults */
$pageTitle   = isset($pageTitle)   ? e($pageTitle) . ' — ' . APP_NAME : APP_NAME . ' — ' . APP_TAGLINE;
$pageDesc    = isset($pageDesc)    ? e($pageDesc)  : 'Découvrez, cataloguez et partagez votre bibliothèque de jeux vidéo.';
$activeNav   = $activeNav   ?? '';
$user        = currentUser();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $pageDesc ?>">
    <title><?= $pageTitle ?></title>
    <link rel="stylesheet" href="/reset.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

<?= flashHtml() ?>

<nav class="navbar">
    <div class="container">
        <div class="logo">
            <h1><a href="/index.php">GameLib</a></h1>
        </div>

        <ul class="nav-links">
            <li><a href="/index.php"            class="<?= $activeNav==='home'       ?'active':'' ?>">Accueil</a></li>
            <li><a href="/pages/games.php"       class="<?= $activeNav==='games'      ?'active':'' ?>">Jeux</a></li>
            <li><a href="/pages/categories.php"  class="<?= $activeNav==='categories' ?'active':'' ?>">Catégories</a></li>
            <li><a href="/pages/collections.php" class="<?= $activeNav==='collections'?'active':'' ?>">Collections</a></li>
            <?php if ($user): ?>
                <li><a href="/pages/profile.php" class="<?= $activeNav==='profile'?'active':'' ?>">
                    <?= e($user['avatar']) ?> <?= e($user['username']) ?>
                </a></li>
                <li><a href="/logout.php">Déconnexion</a></li>
            <?php else: ?>
                <li><a href="/pages/login.php"    class="<?= $activeNav==='login'   ?'active':'' ?>">Connexion</a></li>
                <li><a href="/pages/register.php" class="btn-nav-cta">Inscription</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>