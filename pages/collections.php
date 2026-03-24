<?php
/*
** ESGI PROJECT, 2025
** pages/collections.php
** File description:
** Public and personal game collections
*/

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../data/mock.php';

$pageTitle = 'Collections';
$pageDesc  = 'Découvrez les collections de jeux créées par la communauté GameLib.';
$activeNav = 'collections';
$user      = currentUser();

/* Separate public from personal */
$publicCols   = array_filter($COLLECTIONS, fn($c) => $c['public'] === true);
$personalCols = array_filter($COLLECTIONS, fn($c) => $c['public'] === false);

require_once __DIR__ . '/../includes/header.php';
?>

<!-- Page Hero -->
<div class="page-hero">
    <div class="container">
        <div class="page-hero-content">
            <div class="page-hero-eyebrow">
                <div class="page-hero-eyebrow-line"></div>
                <span>Curation communautaire</span>
            </div>
            <h1>Les <span class="gradient-text">Collections</span></h1>
            <p>Des sélections de jeux soignées par notre communauté — thématiques, genres, ambiances.</p>
        </div>
    </div>
</div>

<main style="padding:60px 0 80px;">
    <div class="container">

        <!-- Curated Collections -->
        <div class="section-header" style="margin-bottom:32px;">
            <div class="section-header-left">
                <div class="badge badge-primary" style="margin-bottom:12px;">🌟 Sélection</div>
                <h2 class="section-title">Collections <span>Communauté</span></h2>
                <p class="section-subtitle">Sélections thématiques plébiscitées par nos membres</p>
            </div>
            <?php if ($user): ?>
            <button class="btn-primary" style="font-size:.85rem;padding:10px 20px;">+ Créer une collection</button>
            <?php endif; ?>
        </div>

        <div class="collections-grid" style="margin-bottom:60px;">
            <?php foreach ($publicCols as $col): ?>
            <a href="#" class="collection-card">
                <div style="display:flex;align-items:center;gap:16px;">
                    <div class="collection-icon-wrap"><?= $col['emoji'] ?></div>
                    <div>
                        <h3 style="margin-bottom:2px;"><?= e($col['name']) ?></h3>
                        <p style="font-size:0.75rem;color:var(--color-text-dim);margin:0;">Par <?= e($col['author']) ?></p>
                    </div>
                </div>
                <p><?= e($col['description']) ?></p>
                <div class="collection-footer">
                    <div class="collection-count">🎮 <?= $col['count'] ?> jeux</div>
                    <span>Voir la collection →</span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>

        <!-- Personal section (logged in) -->
        <?php if ($user): ?>
        <div class="section-header" style="margin-bottom:32px;">
            <div class="section-header-left">
                <div class="badge badge-accent" style="margin-bottom:12px;">🔒 Personnel</div>
                <h2 class="section-title">Mes <span>Collections</span></h2>
                <p class="section-subtitle">Vos sélections privées et listes personnalisées</p>
            </div>
        </div>
        <div class="collections-grid">
            <?php foreach ($personalCols as $col): ?>
            <a href="#" class="collection-card">
                <div style="display:flex;align-items:center;gap:16px;">
                    <div class="collection-icon-wrap"><?= $col['emoji'] ?></div>
                    <div>
                        <h3 style="margin-bottom:2px;"><?= e($col['name']) ?></h3>
                        <span class="badge badge-primary" style="font-size:.65rem;">PRIVÉ</span>
                    </div>
                </div>
                <p><?= e($col['description']) ?></p>
                <div class="collection-footer">
                    <div class="collection-count">🎮 <?= $col['count'] ?> jeux</div>
                    <span>Modifier →</span>
                </div>
            </a>
            <?php endforeach; ?>
            <!-- Add new -->
            <div class="collection-card" style="border-style:dashed;justify-content:center;align-items:center;text-align:center;cursor:pointer;gap:12px;">
                <div style="font-size:2rem;">➕</div>
                <h3 style="font-size:0.95rem;">Nouvelle collection</h3>
                <p>Créez une sélection personnalisée de vos jeux préférés.</p>
            </div>
        </div>
        <?php else: ?>
        <!-- CTA for guest -->
        <div style="background:var(--color-bg-card);border:1px solid var(--color-border);border-radius:var(--radius-xl);padding:48px;text-align:center;">
            <div style="font-size:3rem;margin-bottom:20px;">🔐</div>
            <h3 style="font-size:1.2rem;font-weight:700;margin-bottom:10px;">Créez vos propres collections</h3>
            <p style="color:var(--color-text-muted);margin-bottom:28px;max-width:400px;margin-left:auto;margin-right:auto;">
                Inscrivez-vous gratuitement pour créer des sélections personnalisées et garder une trace de vos jeux.
            </p>
            <div style="display:flex;gap:12px;justify-content:center;">
                <a href="/pages/register.php" class="btn-primary">Créer un compte</a>
                <a href="/pages/login.php" class="btn-secondary">Se connecter</a>
            </div>
        </div>
        <?php endif; ?>

    </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
