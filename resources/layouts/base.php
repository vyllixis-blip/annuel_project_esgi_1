<?php
/**
 * Base Layout Template
 * Layout principal pour toutes les pages
 * Variables attendues: $pageTitle, $pageDesc, $activeNav, $content
 */

// Charger les helpers si pas déjà chargés
if (!function_exists('e')) {
    require_once __DIR__ . '/../../includes/functions.php';
}
if (!function_exists('isLoggedIn')) {
    require_once __DIR__ . '/../../includes/auth.php';
}

// Initialiser les variables par défaut
$pageTitle   = $pageTitle ?? 'GameLib';
$pageDesc    = $pageDesc  ?? 'Découvrez, cataloguez et partagez votre bibliothèque de jeux vidéo.';
$activeNav   = $activeNav ?? '';

$user = function_exists('currentUser') ? currentUser() : null;
?><!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= e($pageDesc) ?>">
    <title><?= e($pageTitle) ?> — GameLib</title>
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
            <h1><a href="/">GameLib</a></h1>
        </div>

        <ul class="nav-links">
            <li><a href="/" class="<?= $activeNav === 'home' ? 'active' : '' ?>">Accueil</a></li>
            <li><a href="/games" class="<?= $activeNav === 'games' ? 'active' : '' ?>">Jeux</a></li>
            <li><a href="/discover" class="<?= $activeNav === 'discover' ? 'active' : '' ?>">Découvrir</a></li>
            <li><a href="/categories" class="<?= $activeNav === 'categories' ? 'active' : '' ?>">Catégories</a></li>
            <li><a href="/collections" class="<?= $activeNav === 'collections' ? 'active' : '' ?>">Collections</a></li>
            <?php if ($user): ?>
                <li><a href="/profile" class="<?= $activeNav === 'profile' ? 'active' : '' ?>">
                    <?= e($user['avatar']) ?> <?= e($user['username']) ?>
                </a></li>
                <li><a href="/logout">Déconnexion</a></li>
            <?php else: ?>
                <li><a href="/login" class="<?= $activeNav === 'login' ? 'active' : '' ?>">Connexion</a></li>
                <li><a href="/register" class="btn-nav-cta">Inscription</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<!-- Page Content -->
<?= $content ?? '' ?>

<!-- Footer -->
<footer class="footer">
    <div class="footer-content">
        <div class="footer-section">
            <h3>GameLib</h3>
            <p>Votre plateforme communautaire dédiée à la bibliothèque et la découverte de jeux vidéo. Construite par des joueurs, pour des joueurs.</p>
        </div>

        <div class="footer-section">
            <h4>Navigation</h4>
            <ul>
                <li><a href="/">Accueil</a></li>
                <li><a href="/games">Catalogue</a></li>
                <li><a href="/discover">Découvrir</a></li>
                <li><a href="/categories">Catégories</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h4>Informations</h4>
            <ul>
                <li><a href="/about">À propos</a></li>
                <li><a href="/privacy">Confidentialité</a></li>
                <li><a href="/terms">CGU</a></li>
                <li><a href="/contact">Contact</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h4>Réseaux</h4>
            <div class="social-links">
                <a href="#" title="Twitter">𝕏</a>
                <a href="#" title="Discord">💬</a>
                <a href="#" title="Instagram">📷</a>
                <a href="#" title="GitHub">⌨️</a>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; <?= date('Y') ?> GameLib. Tous droits réservés.</p>
        <div class="footer-bottom-links">
            <a href="/privacy">Politique de Confidentialité</a>
            <a href="/terms">CGU</a>
        </div>
    </div>
</footer>

</body>
</html>
