<?php
/*
** ESGI PROJECT, 2025
** pages/profile.php
** File description:
** User profile — stats, collection, reviews
*/

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../data/mock.php';

requireLogin();

$user = currentUser();

/* Mock user data — replace with real DB queries */
$userStats = [
    ['value' => '31',  'label' => 'Jeux'],
    ['value' => '8',   'label' => 'Critiques'],
    ['value' => '3',   'label' => 'Collections'],
    ['value' => '142', 'label' => 'Heures'],
];

$recentGames  = array_slice($GAMES, 0, 6);
$userReviews  = array_slice($REVIEWS, 0, 3);

$pageTitle = 'Mon Profil — ' . $user['username'];
$activeNav = 'profile';

require_once __DIR__ . '/../includes/header.php';
?>

<!-- Profile Header -->
<div class="profile-header">
    <div class="container">
        <div class="profile-header-inner">

            <!-- Avatar -->
            <div class="profile-avatar-lg"><?= e($user['avatar']) ?></div>

            <!-- Info -->
            <div class="profile-info">
                <h2><?= e($user['username']) ?></h2>
                <p>📧 <?= e($user['email']) ?> &nbsp;·&nbsp; 🎮 Membre depuis 2024</p>

                <div class="profile-stats-row">
                    <?php foreach ($userStats as $s): ?>
                    <div class="stat-item">
                        <span class="stat-value"><?= e($s['value']) ?></span>
                        <span class="stat-label"><?= e($s['label']) ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Edit button -->
            <div style="margin-left:auto;">
                <button class="btn-secondary" style="font-size:.85rem;padding:10px 20px;">✏ Modifier le profil</button>
            </div>
        </div>

        <!-- Tabs -->
        <div class="profile-tabs">
            <a href="#collection" class="profile-tab active">Ma Collection</a>
            <a href="#reviews"    class="profile-tab">Mes Avis</a>
            <a href="#lists"      class="profile-tab">Mes Listes</a>
            <a href="#settings"   class="profile-tab">Paramètres</a>
        </div>
    </div>
</div>

<main style="padding:48px 0 80px;">
    <div class="container">

        <!-- Collection -->
        <div id="collection">
            <div class="section-header" style="margin-bottom:28px;">
                <div class="section-header-left">
                    <h2 class="section-title">Ma <span>Collection</span></h2>
                    <p class="section-subtitle"><?= count($recentGames) ?> jeux dans votre bibliothèque</p>
                </div>
                <a href="/pages/games.php" class="btn-primary" style="font-size:.85rem;padding:10px 20px;">+ Ajouter un jeu</a>
            </div>

            <div class="games-grid">
                <?php foreach ($recentGames as $game): ?>
                <div class="game-card">
                    <div class="game-card-image">
                        <div class="game-card-placeholder" style="background:<?= e($game['gradient']) ?>;aspect-ratio:3/4;"><?= $game['emoji'] ?></div>
                        <button class="game-card-wishlist" title="Retirer">×</button>
                        <div class="game-card-overlay">
                            <div class="game-card-quick-actions">
                                <a href="/pages/game.php?id=<?= (int)$game['id'] ?>" class="quick-btn quick-btn-primary">Voir</a>
                                <button class="quick-btn quick-btn-secondary">Avis</button>
                            </div>
                        </div>
                    </div>
                    <div class="game-card-body">
                        <p class="game-card-genre"><?= e($game['genre']) ?></p>
                        <h3 class="game-card-title"><?= e($game['title']) ?></h3>
                        <div class="game-card-meta">
                            <span><?= (int)$game['year'] ?></span>
                            <div class="game-card-rating">★ <?= number_format($game['rating'], 1) ?></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Reviews -->
        <div id="reviews" style="margin-top:64px;">
            <div class="section-header" style="margin-bottom:28px;">
                <div class="section-header-left">
                    <h2 class="section-title">Mes <span>Avis</span></h2>
                    <p class="section-subtitle"><?= count($userReviews) ?> critiques rédigées</p>
                </div>
            </div>
            <div class="reviews-grid">
                <?php foreach ($userReviews as $r): ?>
                <div class="review-card">
                    <div class="review-header">
                        <div class="review-avatar"><?= e($user['avatar']) ?></div>
                        <div>
                            <p class="review-author"><?= e($user['username']) ?></p>
                            <p class="review-date"><?= e($r['date']) ?></p>
                        </div>
                        <div class="review-rating">★ <?= $r['rating'] ?>/10</div>
                    </div>
                    <p class="review-text"><?= e($r['text']) ?></p>
                    <div style="display:flex;gap:8px;margin-top:12px;">
                        <button class="quick-btn quick-btn-secondary" style="font-size:.75rem;">✏ Modifier</button>
                        <button class="quick-btn quick-btn-secondary" style="font-size:.75rem;color:#ef4444;">🗑 Supprimer</button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Settings -->
        <div id="settings" style="margin-top:64px;max-width:600px;">
            <h2 class="section-title" style="margin-bottom:28px;">Paramètres <span>du compte</span></h2>

            <div style="background:var(--color-bg-card);border:1px solid var(--color-border);border-radius:var(--radius-xl);padding:32px;margin-bottom:20px;">
                <h3 style="font-size:1rem;font-weight:700;margin-bottom:20px;">Informations personnelles</h3>
                <div class="form-group">
                    <label class="form-label">Pseudo</label>
                    <input type="text" class="form-input" value="<?= e($user['username']) ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">E-mail</label>
                    <input type="email" class="form-input" value="<?= e($user['email']) ?>">
                </div>
                <button class="btn-primary" style="font-size:.85rem;padding:10px 20px;">Enregistrer</button>
            </div>

            <div style="background:var(--color-bg-card);border:1px solid rgba(239,68,68,.3);border-radius:var(--radius-xl);padding:32px;">
                <h3 style="font-size:1rem;font-weight:700;margin-bottom:10px;color:#ef4444;">Zone dangereuse</h3>
                <p style="font-size:0.85rem;color:var(--color-text-muted);margin-bottom:20px;">
                    La suppression de votre compte est irréversible. Toutes vos données seront effacées.
                </p>
                <button style="padding:10px 20px;background:rgba(239,68,68,.15);color:#ef4444;border:1px solid rgba(239,68,68,.3);border-radius:var(--radius-md);font-size:.85rem;font-weight:600;cursor:pointer;font-family:var(--font-sans);transition:var(--transition);">
                    Supprimer mon compte
                </button>
            </div>
        </div>

    </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
