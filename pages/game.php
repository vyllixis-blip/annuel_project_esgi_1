<?php
/*
** ESGI PROJECT, 2025
** pages/game.php
** File description:
** Single game detail page
*/

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../data/mock.php';

$id   = (int)($_GET['id'] ?? 0);
$game = findGame($id, $GAMES);

if (!$game) {
    header('HTTP/1.1 404 Not Found');
    $pageTitle = 'Jeu introuvable';
    $activeNav = 'games';
    require_once __DIR__ . '/../includes/header.php';
    echo '<div style="text-align:center;padding:160px 24px;">
        <div style="font-size:4rem;margin-bottom:24px;">🎮</div>
        <h2 style="font-size:1.5rem;font-weight:800;margin-bottom:12px;">Jeu introuvable</h2>
        <p style="color:var(--color-text-muted);margin-bottom:28px;">Ce jeu n\'existe pas dans notre catalogue.</p>
        <a href="/pages/games.php" class="btn-primary">← Retour au catalogue</a>
    </div>';
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}

/* Related games — same genre, excluding current */
$related = array_filter($GAMES, fn($g) =>
    $g['id'] !== $game['id'] &&
    str_contains(mb_strtolower($g['genre']), mb_strtolower(explode('-', $game['genre'])[0]))
);
$related = array_slice(array_values($related), 0, 4);

$pageTitle = $game['title'];
$pageDesc  = truncate($game['description'], 160);
$activeNav = 'games';

require_once __DIR__ . '/../includes/header.php';
?>

<!-- Game Detail Hero -->
<div class="game-detail-hero">
    <div class="container">
        <div class="game-detail-header">

            <!-- Cover -->
            <div class="game-detail-cover" style="background:<?= e($game['gradient']) ?>;">
                <span><?= $game['emoji'] ?></span>
            </div>

            <!-- Info -->
            <div class="game-detail-info">
                <!-- Breadcrumb -->
                <nav style="font-size:0.8rem;color:var(--color-text-dim);margin-bottom:20px;">
                    <a href="/index.php" style="color:var(--color-text-dim);">Accueil</a>
                    <span style="margin:0 8px;">›</span>
                    <a href="/pages/games.php" style="color:var(--color-text-dim);">Jeux</a>
                    <span style="margin:0 8px;">›</span>
                    <span style="color:var(--color-primary-light);"><?= e($game['title']) ?></span>
                </nav>

                <?php if ($game['badge'] ?? false): ?>
                <span class="badge <?= badgeClass($game['badge']['type']) ?>" style="margin-bottom:16px;">
                    🏆 <?= e($game['badge']['label']) ?>
                </span>
                <?php endif; ?>

                <h1 style="font-size:clamp(2rem,4vw,3rem);font-weight:800;letter-spacing:-0.03em;margin-bottom:12px;line-height:1.1;">
                    <?= e($game['title']) ?>
                </h1>

                <p style="font-size:0.9rem;color:var(--color-text-muted);margin-bottom:20px;line-height:1.7;">
                    <?= e($game['description']) ?>
                </p>

                <!-- Rating row -->
                <div style="display:flex;align-items:center;gap:16px;margin-bottom:24px;">
                    <?= renderStars($game['rating']) ?>
                    <span style="font-size:1.6rem;font-weight:800;color:var(--color-accent-warm);">
                        <?= number_format($game['rating'], 1) ?>
                    </span>
                    <span style="font-size:0.85rem;color:var(--color-text-dim);">/10</span>
                </div>

                <!-- Meta grid -->
                <div class="game-detail-meta-grid">
                    <div class="game-detail-meta-item">
                        <label>Genre</label>
                        <span><?= e($game['genre']) ?></span>
                    </div>
                    <div class="game-detail-meta-item">
                        <label>Studio</label>
                        <span><?= e($game['studio'] ?? '—') ?></span>
                    </div>
                    <div class="game-detail-meta-item">
                        <label>Année</label>
                        <span><?= (int)$game['year'] ?></span>
                    </div>
                    <div class="game-detail-meta-item">
                        <label>Joueurs</label>
                        <span><?= e($game['plays'] ?? '—') ?></span>
                    </div>
                </div>

                <!-- Tags -->
                <?php if (!empty($game['tags'])): ?>
                <div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:24px;">
                    <?php foreach ($game['tags'] as $tag): ?>
                    <a href="/pages/games.php?q=<?= urlencode($tag) ?>" class="hero-tag"><?= e($tag) ?></a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- Actions -->
                <div class="game-detail-actions">
                    <?php if (isLoggedIn()): ?>
                        <button class="btn-primary">+ Ma collection</button>
                        <button class="btn-secondary">❤ Favori</button>
                    <?php else: ?>
                        <a href="/pages/register.php" class="btn-primary">Créer un compte pour sauvegarder</a>
                    <?php endif; ?>
                    <a href="/pages/games.php" class="btn-secondary">← Retour</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reviews -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-header-left">
                <h2 class="section-title">Critiques <span>Communauté</span></h2>
                <p class="section-subtitle"><?= count($REVIEWS) ?> avis sur ce jeu</p>
            </div>
            <?php if (isLoggedIn()): ?>
            <button class="btn-primary" style="font-size:.85rem;padding:10px 20px;">✏ Rédiger un avis</button>
            <?php else: ?>
            <a href="/pages/login.php" class="btn-secondary" style="font-size:.85rem;padding:10px 20px;">Connectez-vous pour noter</a>
            <?php endif; ?>
        </div>

        <div class="reviews-grid">
            <?php foreach ($REVIEWS as $r): ?>
            <div class="review-card">
                <div class="review-header">
                    <div class="review-avatar"><?= $r['avatar'] ?></div>
                    <div>
                        <p class="review-author"><?= e($r['author']) ?></p>
                        <p class="review-date"><?= e($r['date']) ?></p>
                    </div>
                    <div class="review-rating">★ <?= $r['rating'] ?>/10</div>
                </div>
                <p class="review-text"><?= e($r['text']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Related Games -->
<?php if (!empty($related)): ?>
<section class="section" style="padding-top:0;background:var(--color-bg-alt);border-top:1px solid var(--color-border);padding-bottom:60px;">
    <div class="container">
        <div class="section-header">
            <div class="section-header-left">
                <h2 class="section-title">Jeux <span>Similaires</span></h2>
            </div>
            <a href="/pages/games.php?genre=<?= urlencode(strtolower($game['genre'])) ?>" class="section-link">Voir plus →</a>
        </div>
        <div class="games-grid" style="grid-template-columns:repeat(auto-fill,minmax(200px,1fr));">
            <?php foreach ($related as $r): ?>
            <div class="game-card">
                <div class="game-card-image">
                    <div class="game-card-placeholder" style="background:<?= e($r['gradient']) ?>;aspect-ratio:3/4;"><?= $r['emoji'] ?></div>
                    <div class="game-card-overlay">
                        <div class="game-card-quick-actions">
                            <a href="/pages/game.php?id=<?= (int)$r['id'] ?>" class="quick-btn quick-btn-primary">Voir</a>
                        </div>
                    </div>
                </div>
                <div class="game-card-body">
                    <p class="game-card-genre"><?= e($r['genre']) ?></p>
                    <h3 class="game-card-title"><a href="/pages/game.php?id=<?= (int)$r['id'] ?>" style="color:inherit;"><?= e($r['title']) ?></a></h3>
                    <div class="game-card-meta">
                        <span><?= (int)$r['year'] ?></span>
                        <div class="game-card-rating">★ <?= number_format($r['rating'],1) ?></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
