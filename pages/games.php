<?php
/*
** ESGI PROJECT, 2025
** pages/games.php
** File description:
** Full game catalogue with search, filters and pagination
*/

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../data/mock.php';

/* ─── Input sanitisation ────────────────────────────────────────── */
$q      = trim($_GET['q']     ?? '');
$genre  = trim($_GET['genre'] ?? '');
$sort   = in_array($_GET['sort'] ?? '', ['rating','newest','oldest','az','za']) ? $_GET['sort'] : 'rating';
$page   = max(1, (int)($_GET['page'] ?? 1));

/* ─── Filter + paginate ─────────────────────────────────────────── */
$filtered   = filterGames($GAMES, $q, $genre, $sort);
$paginated  = paginate($filtered, $page, GAMES_PER_PAGE);
$games      = $paginated['items'];

/* ─── Page meta ─────────────────────────────────────────────────── */
$pageTitle  = 'Catalogue de Jeux';
$pageDesc   = 'Explorez notre catalogue de plus de 1 400 jeux vidéo. Filtrez par genre, note ou année.';
$activeNav  = 'games';

require_once __DIR__ . '/../includes/header.php';
?>

<!-- Page Hero -->
<div class="page-hero">
    <div class="container">
        <div class="page-hero-content">
            <div class="page-hero-eyebrow">
                <div class="page-hero-eyebrow-line"></div>
                <span>Catalogue complet</span>
            </div>
            <h1>Tous les <span class="gradient-text">Jeux</span></h1>
            <p><?= fmtNumber($paginated['total']) ?> jeu<?= $paginated['total'] > 1 ? 's' : '' ?> dans notre base — filtre, trie, explore.</p>
        </div>
    </div>
</div>

<!-- Sticky Filter Bar -->
<div class="filter-bar">
    <div class="container">
        <form class="filter-bar-inner" method="GET" action="/pages/games.php" id="filter-form">

            <!-- Search -->
            <div class="filter-search">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input
                    type="text"
                    name="q"
                    value="<?= e($q) ?>"
                    placeholder="Titre, studio, genre…"
                    autocomplete="off"
                    oninput="document.getElementById('filter-form').submit()"
                >
            </div>

            <!-- Genre -->
            <select name="genre" class="filter-select" onchange="this.form.submit()">
                <option value="">Tous les genres</option>
                <?php foreach ($CATEGORIES as $cat): ?>
                    <option value="<?= e($cat['slug']) ?>" <?= $genre === $cat['slug'] ? 'selected' : '' ?>>
                        <?= e($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Sort -->
            <select name="sort" class="filter-select" onchange="this.form.submit()">
                <option value="rating"  <?= $sort==='rating'  ? 'selected':'' ?>>Meilleures notes</option>
                <option value="newest"  <?= $sort==='newest'  ? 'selected':'' ?>>Plus récents</option>
                <option value="oldest"  <?= $sort==='oldest'  ? 'selected':'' ?>>Plus anciens</option>
                <option value="az"      <?= $sort==='az'      ? 'selected':'' ?>>A → Z</option>
                <option value="za"      <?= $sort==='za'      ? 'selected':'' ?>>Z → A</option>
            </select>

            <?php if ($q || $genre): ?>
                <a href="/pages/games.php" class="btn-secondary" style="padding:10px 16px;font-size:0.85rem;white-space:nowrap;">✕ Réinitialiser</a>
            <?php endif; ?>

            <span class="filter-results">
                <?= fmtNumber($paginated['total']) ?> résultat<?= $paginated['total'] > 1 ? 's':'' ?>
            </span>
        </form>
    </div>
</div>

<!-- Games Grid -->
<main style="padding: 48px 0 80px;">
    <div class="container">

        <?php if (empty($games)): ?>
            <div style="text-align:center;padding:80px 0;">
                <div style="font-size:4rem;margin-bottom:24px;">🔍</div>
                <h3 style="font-size:1.3rem;font-weight:700;margin-bottom:10px;">Aucun jeu trouvé</h3>
                <p style="color:var(--color-text-muted);margin-bottom:24px;">Essayez d'autres mots-clés ou retirez les filtres.</p>
                <a href="/pages/games.php" class="btn-primary">Voir tout le catalogue</a>
            </div>
        <?php else: ?>

            <div class="games-grid">
                <?php foreach ($games as $game): ?>
                <div class="game-card">
                    <div class="game-card-image">
                        <div class="game-card-placeholder" style="background:<?= e($game['gradient']) ?>;aspect-ratio:3/4;">
                            <?= $game['emoji'] ?>
                        </div>
                        <?php if ($game['badge'] ?? false): ?>
                        <div class="game-card-badge">
                            <span class="badge <?= badgeClass($game['badge']['type']) ?>" style="font-size:.65rem;">
                                <?= e($game['badge']['label']) ?>
                            </span>
                        </div>
                        <?php endif; ?>
                        <?php if ($game['new'] ?? false): ?>
                        <div style="position:absolute;top:12px;right:12px;">
                            <span class="badge badge-new" style="font-size:.62rem;">NOUVEAU</span>
                        </div>
                        <?php endif; ?>
                        <div class="game-card-overlay">
                            <div class="game-card-quick-actions">
                                <a href="/pages/game.php?id=<?= (int)$game['id'] ?>" class="quick-btn quick-btn-primary">Voir le jeu</a>
                                <button class="quick-btn quick-btn-secondary">+ Collection</button>
                            </div>
                        </div>
                    </div>
                    <div class="game-card-body">
                        <p class="game-card-genre"><?= e($game['genre']) ?></p>
                        <h3 class="game-card-title">
                            <a href="/pages/game.php?id=<?= (int)$game['id'] ?>" style="color:inherit;">
                                <?= e($game['title']) ?>
                            </a>
                        </h3>
                        <div class="game-card-meta">
                            <span><?= e($game['studio'] ?? '') ?> · <?= (int)$game['year'] ?></span>
                            <div class="game-card-rating">★ <?= number_format($game['rating'], 1) ?></div>
                        </div>
                        <?= renderStars($game['rating']) ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if ($paginated['pages'] > 1): ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a class="page-btn" href="?<?= http_build_query(array_merge($_GET, ['page'=>$page-1])) ?>">←</a>
                <?php endif; ?>

                <?php for ($p = 1; $p <= $paginated['pages']; $p++): ?>
                    <a class="page-btn <?= $p===$page?'active':'' ?>"
                       href="?<?= http_build_query(array_merge($_GET, ['page'=>$p])) ?>">
                        <?= $p ?>
                    </a>
                <?php endfor; ?>

                <?php if ($page < $paginated['pages']): ?>
                    <a class="page-btn" href="?<?= http_build_query(array_merge($_GET, ['page'=>$page+1])) ?>">→</a>
                <?php endif; ?>
            </div>
            <?php endif; ?>

        <?php endif; ?>
    </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
